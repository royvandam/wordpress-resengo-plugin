<div class="wrap">
<h1><?php echo __("Resengo Widget Settings",$this->plugin_name); ?></h1>

<form method="post" action="">
<table class="form-table" role="presentation">
	<tbody>
		<tr>
			<th scope="row"><label for="resengo_company_id"><?php echo __("Company ID",$this->plugin_name); ?></label></th>
			<td><input name="resengo_company_id" type="text" value= "<?php echo ((get_option("resengo_company_id") != "") ? get_option("resengo_company_id") : ''); ?>" id="resengo_company_id" value="<?php echo get_option("ab_app_id"); ?>" class="regular-text" /></td>
		</tr>		
		<tr>
			<th scope="row"><label for="framed"><?php echo __("Language",$this->plugin_name); ?></label></th>
			<td>
				<select name="resengo_language" id="resengo_language" class="regular-text" >
					<option value="LOCALE" <?php echo ((get_option("resengo_language") == "LOCALE" || get_option("resengo_language") == "") ? 'selected' : ''); ?>>Automatically (based on locale)</option>
					<option value="NL" <?php echo ((get_option("resengo_language") == "NL") ? 'selected' : ''); ?>>NL</option>
					<option value="DE" <?php echo ((get_option("resengo_language") == "DE") ? 'selected' : ''); ?>>DE</option>
					<option value="EN" <?php echo ((get_option("resengo_language") == "EN") ? 'selected' : ''); ?>>EN</option>
					<option value="ES" <?php echo ((get_option("resengo_language") == "ES") ? 'selected' : ''); ?>>ES</option>
					<option value="FR" <?php echo ((get_option("resengo_language") == "FR") ? 'selected' : ''); ?>>FR</option>
				</select>
			</td>
		</tr>	
	</tbody>
</table>

<p class="submit"><input type="submit" name="resengo_submit" id="resengo_submit" class="button button-primary" value="<?php echo __("Save Changes",$this->plugin_name); ?>"></p></form>

</div>
