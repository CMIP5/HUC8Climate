<?php $this->load->view('header'); ?>

		<p>
		The SNOTEL hydrologic data web services provide access to snow water equivalent, precipitation and air temperature data from the National Resources Conservation Service (NRCS)
		Snow Telemetry (SNOTEL) observation network. The web service retrieves data from the NRCS SNOTEL website, formats it as WaterML, and returns it to the user.
		</p>
		<br />
		<div id="base_info">
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/test';?>" class="info_link">REST Service Test</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;You can perform tests on all of the WaterML web service methods on this page. In this case the test for REST Service.
					</div>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/cuahsi_1_1.asmx';?>" class="info_link">SOAP Web Service</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;Hydroserver soap service page. Use this page for HydroDesktop and HIS Central catalog.
					</div>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/wfs/write_xml?service=WFS&request=GetCapabilities&version=1.0.0';?>" class="info_link">WFS Services</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;WFS 1.0.0.
					</div>
				</div> 
			</div>
			<div class="info_container">
			    <label class="info_label"><a href="<?php echo 'index.php/wfs/write_xml?service=WFS&request=GetCapabilities&version=2.0.0';?>" class="info_link">WFS Services</a></label>
				<div class="info_content">
					<div class="link_desc">
						&nbsp;WFS 2.0.0.
					</div>
				</div> 
			</div>
		</div>
	
<?php $this->load->view('footer'); ?>