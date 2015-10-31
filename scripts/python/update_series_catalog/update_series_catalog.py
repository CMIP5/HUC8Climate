__author__ = 'Jiri'

##################################################

import requests
import pymysql
import pymysql.cursors

class SeriesCatalogUpdater(object):

    def __init__(self):
        self.HYDROSERVER_URL = 'http://worldwater.byu.edu/app/index.php/climate/services/api/'
        self.HYDROSERVER_HOST = 'worldwater.byu.edu'
        self.HYDROSERVER_DB_NAME = 'climate'
        self.HYDROSERVER_DB_USER = 'YOUR_DB_USER_NAME' #replace this with the real MySQL db user name
        self.HYDROSERVER_DB_PASSWORD = 'YOUR_DB_PASSWORD'    #replace this with the real MySQL db password

    def get_sites(self):
        url = self.HYDROSERVER_URL + 'GetSitesJSON'
        r = requests.get(url)
        sites = r.json()
        return sites

    def get_sites_from_db(self):
        connection = pymysql.connect(host=self.HYDROSERVER_HOST,
                                     user=self.HYDROSERVER_DB_USER,
                                     passwd=self.HYDROSERVER_DB_PASSWORD,
                                     db=self.HYDROSERVER_DB_NAME,
                                     cursorclass=pymysql.cursors.DictCursor)
        cur = connection.cursor()
        sql = 'SELECT * FROM sites'
        cur.execute(sql)
        rows = cur.fetchall()
        sites = []
        for row in rows:
            sites.append(row)

        connection.close()
        return sites




    def get_variables(self):
        url = self.HYDROSERVER_URL + 'GetVariablesJSON'
        r = requests.get(url)
        variables = r.json()
        return variables


    def get_methods(self):
        url = self.HYDROSERVER_URL + 'GetMethodsJSON'
        r = requests.get(url)
        methods = r.json()
        return methods


    def get_sources(self):
        url = self.HYDROSERVER_URL + 'GetSourcesJSON'
        r = requests.get(url)
        methods = r.json()
        return methods


    def number_of_months(self, beginYear, beginMonth, endYear, endMonth):
        monthsInFirstYear = 12 - beginMonth + 1
        monthsInLastYear = endMonth
        monthsBetween = monthsInFirstYear + (endYear - beginYear - 1) * 12 + monthsInLastYear
        return monthsBetween

    # returns the time interval related to the method
    def get_method_info(self, method):
        desc = method['MethodDescription']
        index = desc.rindex('_') + 1
        interval = desc[index:]
        beginDateStr = interval.split('-')[0]
        endDateStr = interval.split('-')[1]
        beginYear = int(beginDateStr[0:4])
        beginMonth = int(beginDateStr[4:6])
        endYear = int(endDateStr[0:4])
        endMonth = int(endDateStr[4:6])
        valueCount = self.number_of_months(beginYear, beginMonth, endYear, endMonth)
        beginTime = '%04d-%02d-14' % (beginYear, beginMonth)
        endTime = '%04d-%02d-14' % (endYear, endMonth)
        return {'beginTime': beginTime, 'endTime': endTime, 'valueCount': valueCount}



    def make_sql(self, source, variable, site, method):
        # prepare the INSERT SQL statement
        sql_base = 'INSERT INTO seriescatalog(siteid, sitecode, sitename, sitetype, \
        variableid, variablecode, variablename, speciation, variableunitsid, variableunitsname, \
        samplemedium, valuetype, timesupport, timeunitsid, timeunitsname, datatype, generalcategory, \
        methodid, methoddescription, \
        sourceid, organization, sourcedescription, citation, \
        qualitycontrollevelid, qualitycontrollevelcode, \
        begindatetime, enddatetime, begindatetimeutc, enddatetimeutc, valuecount) VALUES ('

        # properties related to variable
        variableid = int(variable['VariableID'])
        variablecode = variable['VariableCode']
        variablename = variable['VariableName']
        speciation = variable['Speciation']
        variableunitsid = variable['unitsID']
        variableunitsname = variable['unitsName']
        samplemedium = variable['SampleMedium']
        valuetype = variable['ValueType']
        timesupport = variable['TimeSupport']
        timeunitsid = variable['TimeunitsID']
        timeunitsname = 'Month'
        datatype = variable['DataType']
        generalcategory = variable['GeneralCategory']
        sql_variable = "%d,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'," % \
            (variableid, variablecode, variablename, speciation, variableunitsid, variableunitsname, samplemedium,\
             valuetype, timesupport, timeunitsid, timeunitsname, datatype, generalcategory)

        # properties related to source
        sourceid = int(source['SourceID'])
        organization = source['Organization']
        sourcedescription = source['SourceDescription']
        citation = source['Citation']
        sql_source = "%d,'%s','%s','%s'," % (sourceid, organization, sourcedescription, citation)

        # properties related to site
        siteid = int(site['SiteID'])
        sitecode = site['SiteCode']
        sitename = site['SiteName'].replace("'","''")
        sitetype = 'Unknown'
        sql_site = "%d,'%s','%s','%s'," % (siteid, sitecode, sitename, sitetype)

        qualitycontrollevelid = 1
        qualitycontrollevelcode = '1'
        sql_qc = "%d,'%s'," % (qualitycontrollevelid, qualitycontrollevelcode)

        # properties related to method
        methodid = int(method['MethodID'])
        methoddescription = method['MethodDescription']
        sql_method = "%d,'%s'," % (methodid, methoddescription)

        # properties related to time interval
        t_info = self.get_method_info(method)
        begindatetime = t_info['beginTime']
        enddatetime = t_info['endTime']
        begintimeutc = t_info['beginTime']
        endtimeutc = t_info['endTime']
        valuecount = t_info['valueCount']
        sql_time = "'%s','%s','%s','%s',%d)" % (begindatetime, enddatetime, begintimeutc, endtimeutc, valuecount)

        # construct the final SQL statement
        sql_final = sql_base + sql_site + sql_variable + sql_method + sql_source + sql_qc + sql_time
        return sql_final


    def run(self, variable_name):
        variables = self.get_variables()

        if variable_name == 'precipitation':
            variable = variables[0]
            print variable['VariableName']
        else:
            variable = variables[1]
            print variable['VariableName']

        source = self.get_sources()[0]
        sites = self.get_sites_from_db()
        methods = self.get_methods()

        # filtering eligible methods for precipitation
        methods_pr = []

        if variable_name == 'precipitation':
            for meth in methods:
                desc = meth['MethodDescription']
                if '_pr_' in desc:
                    methods_pr.append(meth)
        else:
            for meth in methods:
                desc = meth['MethodDescription']
                if not '_pr_' in desc:
                    print desc
                    methods_pr.append(meth)

        print 'inserting %d series' % (len(sites) * len(methods_pr),)

        # for each site, method insert a new series catalog entry
        connection = pymysql.connect(host=self.HYDROSERVER_HOST,
                                     user=self.HYDROSERVER_DB_USER,
                                     passwd=self.HYDROSERVER_DB_PASSWORD,
                                     db=self.HYDROSERVER_DB_NAME,
                                     cursorclass=pymysql.cursors.DictCursor)
        num_series = 0
        for method in methods_pr:
            for site in sites:
                cur = connection.cursor()
                SQL = self.make_sql(source, variable, site, method)
                # print SQL
                cur.execute(SQL)
                num_series = num_series + 1
            print 'method: %s total: %d' % (method['MethodDescription'], num_series)
            connection.commit()


        print '%d series inserted!' % (num_series,)
        return(methods_pr)




scu = SeriesCatalogUpdater()
#scu.run('precipitation')
method_list = scu.run('temperature')
print method_list
#scu.get_sites_from_db()