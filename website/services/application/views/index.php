<?php $this->load->view('header'); ?>

		<p>
		The climate forecast models for USGS HUC8 Watersheds provide monthly temperature and precipitation data scaled to the spatial resolution 
		of each USGS Hydrologic Unit Code (HUC8) watershed in the contiguous U.S. The historical data ranges from 1950 to 2006. 
		The future predictions cover the time period 2006 - 2100 according to different global climate models and future climate scenarios. 
		This data is based off the larger CMIP5 data collection. The time series data is provided in the WaterML format.
		</p>
		<br />
		<h2>Example Queries</h2>
		<div id="base_info">
			<div class="info_container">
			    <label class="info_label">
						Get all HUC8 Watersheds in WaterML format
				</label>
				<div class="link_desc">
					&nbsp;&nbsp;<a href="index.php/cuahsi_1_1.asmx/GetSitesObject" class="info_link">index.php/cuahsi_1_1.asmx/GetSitesObject</a>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label">
						Get all Variables in WaterML format
				</label>
				<div class="link_desc">
					&nbsp;&nbsp;<a href="index.php/cuahsi_1_1.asmx/GetVariablesObject" class="info_link">index.php/cuahsi_1_1.asmx/GetVariablesObject</a>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label">
						List all available climate models for a HUC8 watershed in WaterML
				</label>
				<div class="link_desc">
					&nbsp;&nbsp;<a href="index.php/cuahsi_1_1.asmx/GetSiteInfoObject?site=CMIP5:02080203" class="info_link">
					index.php/cuahsi_1_1.asmx/GetSiteInfoObject?site=CMIP5:02080203</a>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label">
						Precipitation for a HUC8 watershed and time range (data from all models) in WaterML
				</label>
				<div class="link_desc">
					&nbsp;&nbsp;<a href="index.php/cuahsi_1_1.asmx/GetValuesObject?location=CMIP5:02080203&variable=CMIP5:pr&startDate=2080-01-01&endDate=2080-01-31" class="info_link">
					index.php/cuahsi_1_1.asmx/GetValuesObject?location=CMIP5:02080203&variable=CMIP5:pr&startDate=2080-01-01&endDate=2080-01-31</a>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label">
						Precipitation for a HUC8 watershed, selected model, and time range in WaterML
				</label>
				<div class="link_desc">
					&nbsp;&nbsp;<a href="index.php/cuahsi_1_1.asmx/GetValuesObject?location=CMIP5:02080203&variable=CMIP5:pr:methodCode=1&startDate=2016-01-01&endDate=2100-01-31" class="info_link">
					index.php/cuahsi_1_1.asmx/GetValuesObject?location=CMIP5:02080203&variable=CMIP5:pr:methodCode=1&startDate=2016-01-01&endDate=2100-01-31</a>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/test';?>" class="info_link">REST Service Test</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;You can perform tests on all of the methods in Hydrodata Server on this page. In this case the test for REST Service.
					</div>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/cuahsi_1_1.asmx';?>" class="info_link">SOAP Web Service</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;Hydroserver soap service page.
					</div>
				</div> 
			</div>
		</div>
	
<?php $this->load->view('footer'); ?>