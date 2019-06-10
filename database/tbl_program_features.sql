<!DOCTYPE html>
<html lang="en" dir="ltr">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta name="robots" content="noindex">
<meta name="referrer" content="origin-when-crossorigin">
<title>Export: agency_thrive_db - Adminer</title>
<link rel="stylesheet" type="text/css" href="adminer.php?file=default.css&amp;version=4.3.1">
<script type="text/javascript" src="adminer.php?file=functions.js&amp;version=4.3.1"></script>
<link rel="shortcut icon" type="image/x-icon" href="adminer.php?file=favicon.ico&amp;version=4.3.1">
<link rel="apple-touch-icon" href="adminer.php?file=favicon.ico&amp;version=4.3.1">

<body class="ltr nojs" onkeydown="bodyKeydown(event);" onclick="bodyClick(event);">
<script type="text/javascript">
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = 'You are offline.';
</script>

<div id="help" class="jush-sql jsonly hidden" onmouseover="helpOpen = 1;" onmouseout="helpMouseout(this, event);"></div>

<div id="content">
<p id="breadcrumb"><a href="adminer.php">MySQL</a> &raquo; <a href='adminer.php?username=root' accesskey='1' title='Alt+Shift+1'>Server</a> &raquo; <a href="adminer.php?username=root&amp;db=agency_thrive_db">agency_thrive_db</a> &raquo; Export
<h2>Export: agency_thrive_db</h2>
<div id='ajaxstatus' class='jsonly hidden'></div>

<form action="" method="post">
<table cellspacing="0">
<tr><th>Output<td><label><input type='radio' name='output' value='text' checked>open</label><label><input type='radio' name='output' value='file'>save</label><label><input type='radio' name='output' value='gz'>gzip</label>
<tr><th>Format<td><label><input type='radio' name='format' value='sql' checked>SQL</label><label><input type='radio' name='format' value='csv'>CSV,</label><label><input type='radio' name='format' value='csv;'>CSV;</label><label><input type='radio' name='format' value='tsv'>TSV</label>
<tr><th>Database<td><select name='db_style'><option selected><option>USE<option>DROP+CREATE<option>CREATE</select><label><input type='checkbox' name='routines' value='1'>Routines</label><label><input type='checkbox' name='events' value='1'>Events</label><tr><th>Tables<td><select name='table_style'><option><option selected>DROP+CREATE<option>CREATE</select><label><input type='checkbox' name='auto_increment' value='1'>Auto Increment</label><label><input type='checkbox' name='triggers' value='1' checked>Triggers</label><tr><th>Data<td><select name='data_style'><option><option>TRUNCATE+INSERT<option selected>INSERT<option>INSERT+UPDATE</select></table>
<p><input type="submit" value="Export">
<input type="hidden" name="token" value="311784:446961">

<table cellspacing="0">
<thead><tr><th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables' onclick='formCheck(this, /^tables\[/);'>Tables</label><th style='text-align: right;'><label class='block'>Data<input type='checkbox' id='check-data' onclick='formCheck(this, /^data\[/);'></label></thead>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_02_models' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_02_models</label><td align='right'><label class='block'><span id='Rows-tbl_02_models'></span><input type='checkbox' name='data[]' value='tbl_02_models' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_account_setup' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_account_setup</label><td align='right'><label class='block'><span id='Rows-tbl_account_setup'></span><input type='checkbox' name='data[]' value='tbl_account_setup' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_account_setup_policy' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_account_setup_policy</label><td align='right'><label class='block'><span id='Rows-tbl_account_setup_policy'></span><input type='checkbox' name='data[]' value='tbl_account_setup_policy' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_action_item' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_action_item</label><td align='right'><label class='block'><span id='Rows-tbl_action_item'></span><input type='checkbox' name='data[]' value='tbl_action_item' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_action_type' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_action_type</label><td align='right'><label class='block'><span id='Rows-tbl_action_type'></span><input type='checkbox' name='data[]' value='tbl_action_type' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_activity_meta' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_activity_meta</label><td align='right'><label class='block'><span id='Rows-tbl_activity_meta'></span><input type='checkbox' name='data[]' value='tbl_activity_meta' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_appointment' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_appointment</label><td align='right'><label class='block'><span id='Rows-tbl_appointment'></span><input type='checkbox' name='data[]' value='tbl_appointment' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_audit_logs' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_audit_logs</label><td align='right'><label class='block'><span id='Rows-tbl_audit_logs'></span><input type='checkbox' name='data[]' value='tbl_audit_logs' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_billing' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_billing</label><td align='right'><label class='block'><span id='Rows-tbl_billing'></span><input type='checkbox' name='data[]' value='tbl_billing' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_charges_fee' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_charges_fee</label><td align='right'><label class='block'><span id='Rows-tbl_charges_fee'></span><input type='checkbox' name='data[]' value='tbl_charges_fee' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_ci_review' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_ci_review</label><td align='right'><label class='block'><span id='Rows-tbl_ci_review'></span><input type='checkbox' name='data[]' value='tbl_ci_review' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_client_resources' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_client_resources</label><td align='right'><label class='block'><span id='Rows-tbl_client_resources'></span><input type='checkbox' name='data[]' value='tbl_client_resources' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_colour_custom' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_colour_custom</label><td align='right'><label class='block'><span id='Rows-tbl_colour_custom'></span><input type='checkbox' name='data[]' value='tbl_colour_custom' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_colour_scheme' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_colour_scheme</label><td align='right'><label class='block'><span id='Rows-tbl_colour_scheme'></span><input type='checkbox' name='data[]' value='tbl_colour_scheme' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_credit_card_settings' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_credit_card_settings</label><td align='right'><label class='block'><span id='Rows-tbl_credit_card_settings'></span><input type='checkbox' name='data[]' value='tbl_credit_card_settings' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_current_coverage' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_current_coverage</label><td align='right'><label class='block'><span id='Rows-tbl_current_coverage'></span><input type='checkbox' name='data[]' value='tbl_current_coverage' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_customer' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_customer</label><td align='right'><label class='block'><span id='Rows-tbl_customer'></span><input type='checkbox' name='data[]' value='tbl_customer' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_dependent' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_dependent</label><td align='right'><label class='block'><span id='Rows-tbl_dependent'></span><input type='checkbox' name='data[]' value='tbl_dependent' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_education' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_education</label><td align='right'><label class='block'><span id='Rows-tbl_education'></span><input type='checkbox' name='data[]' value='tbl_education' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_education_resource' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_education_resource</label><td align='right'><label class='block'><span id='Rows-tbl_education_resource'></span><input type='checkbox' name='data[]' value='tbl_education_resource' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_feedback' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_feedback</label><td align='right'><label class='block'><span id='Rows-tbl_feedback'></span><input type='checkbox' name='data[]' value='tbl_feedback' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_goals_concern' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_goals_concern</label><td align='right'><label class='block'><span id='Rows-tbl_goals_concern'></span><input type='checkbox' name='data[]' value='tbl_goals_concern' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_import_excel' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_import_excel</label><td align='right'><label class='block'><span id='Rows-tbl_import_excel'></span><input type='checkbox' name='data[]' value='tbl_import_excel' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_life_changes' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_life_changes</label><td align='right'><label class='block'><span id='Rows-tbl_life_changes'></span><input type='checkbox' name='data[]' value='tbl_life_changes' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_life_changes_options' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_life_changes_options</label><td align='right'><label class='block'><span id='Rows-tbl_life_changes_options'></span><input type='checkbox' name='data[]' value='tbl_life_changes_options' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_long_term_goals' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_long_term_goals</label><td align='right'><label class='block'><span id='Rows-tbl_long_term_goals'></span><input type='checkbox' name='data[]' value='tbl_long_term_goals' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_needs_assessment' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_needs_assessment</label><td align='right'><label class='block'><span id='Rows-tbl_needs_assessment'></span><input type='checkbox' name='data[]' value='tbl_needs_assessment' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_note' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_note</label><td align='right'><label class='block'><span id='Rows-tbl_note'></span><input type='checkbox' name='data[]' value='tbl_note' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_payments' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_payments</label><td align='right'><label class='block'><span id='Rows-tbl_payments'></span><input type='checkbox' name='data[]' value='tbl_payments' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_policies_in_place' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_policies_in_place</label><td align='right'><label class='block'><span id='Rows-tbl_policies_in_place'></span><input type='checkbox' name='data[]' value='tbl_policies_in_place' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_policy_line_question' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_policy_line_question</label><td align='right'><label class='block'><span id='Rows-tbl_policy_line_question'></span><input type='checkbox' name='data[]' value='tbl_policy_line_question' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_program_features' checked onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_program_features</label><td align='right'><label class='block'><span id='Rows-tbl_program_features'></span><input type='checkbox' name='data[]' value='tbl_program_features' checked onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_program_permission' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_program_permission</label><td align='right'><label class='block'><span id='Rows-tbl_program_permission'></span><input type='checkbox' name='data[]' value='tbl_program_permission' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_promo' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_promo</label><td align='right'><label class='block'><span id='Rows-tbl_promo'></span><input type='checkbox' name='data[]' value='tbl_promo' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_referral' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_referral</label><td align='right'><label class='block'><span id='Rows-tbl_referral'></span><input type='checkbox' name='data[]' value='tbl_referral' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_reporting' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_reporting</label><td align='right'><label class='block'><span id='Rows-tbl_reporting'></span><input type='checkbox' name='data[]' value='tbl_reporting' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_security_group' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_security_group</label><td align='right'><label class='block'><span id='Rows-tbl_security_group'></span><input type='checkbox' name='data[]' value='tbl_security_group' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_staff_credits' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_staff_credits</label><td align='right'><label class='block'><span id='Rows-tbl_staff_credits'></span><input type='checkbox' name='data[]' value='tbl_staff_credits' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_top_concerns' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_top_concerns</label><td align='right'><label class='block'><span id='Rows-tbl_top_concerns'></span><input type='checkbox' name='data[]' value='tbl_top_concerns' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_top_concerns_options' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_top_concerns_options</label><td align='right'><label class='block'><span id='Rows-tbl_top_concerns_options'></span><input type='checkbox' name='data[]' value='tbl_top_concerns_options' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<tr><td><label class='block'><input type='checkbox' name='tables[]' value='tbl_user' onclick="checkboxClick(event, this); formUncheck(&#039;check-tables&#039;);">tbl_user</label><td align='right'><label class='block'><span id='Rows-tbl_user'></span><input type='checkbox' name='data[]' value='tbl_user' onclick="checkboxClick(event, this); formUncheck(&#039;check-data&#039;);"></label>
<script type='text/javascript'>ajaxSetHtml('adminer.php?username=root&db=agency_thrive_db&script=db');</script>
</table>
</form>
<p><a href='adminer.php?username=root&amp;db=agency_thrive_db&amp;dump=tbl%25'>tbl</a></div>

<form action='' method='post'>
<div id='lang'>Language: <select name='lang' onchange="this.form.submit();"><option value="en" selected>English<option value="ar">العربية<option value="bg">Български<option value="bn">বাংলা<option value="bs">Bosanski<option value="ca">Català<option value="cs">Čeština<option value="da">Dansk<option value="de">Deutsch<option value="el">Ελληνικά<option value="es">Español<option value="et">Eesti<option value="fa">فارسی<option value="fi">Suomi<option value="fr">Français<option value="gl">Galego<option value="hu">Magyar<option value="id">Bahasa Indonesia<option value="it">Italiano<option value="ja">日本語<option value="ko">한국어<option value="lt">Lietuvių<option value="nl">Nederlands<option value="no">Norsk<option value="pl">Polski<option value="pt">Português<option value="pt-br">Português (Brazil)<option value="ro">Limba Română<option value="ru">Русский<option value="sk">Slovenčina<option value="sl">Slovenski<option value="sr">Српски<option value="ta">த‌மிழ்<option value="th">ภาษาไทย<option value="tr">Türkçe<option value="uk">Українська<option value="vi">Tiếng Việt<option value="zh">简体中文<option value="zh-tw">繁體中文</select> <input type='submit' value='Use' class='hidden'>
<input type='hidden' name='token' value='136854:1679'>
</div>
</form>
<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="Logout" id="logout">
<input type="hidden" name="token" value="311784:446961">
</p>
</form>
<div id="menu">
<h1>
<a href='https://www.adminer.org/' target='_blank' id='h1'>Adminer</a> <span class="version">4.3.1</span>
<a href="https://www.adminer.org/#download" target="_blank" id="version"></a>
</h1>
<script type="text/javascript" src="adminer.php?file=jush.js&amp;version=4.3.1"></script>
<script type="text/javascript">
var jushLinks = { sql: [ 'adminer.php?username=root&db=agency_thrive_db&table=$&', /\b(tbl_02_models|tbl_account_setup|tbl_account_setup_policy|tbl_action_item|tbl_action_type|tbl_activity_meta|tbl_appointment|tbl_audit_logs|tbl_billing|tbl_charges_fee|tbl_ci_review|tbl_client_resources|tbl_colour_custom|tbl_colour_scheme|tbl_credit_card_settings|tbl_current_coverage|tbl_customer|tbl_dependent|tbl_education|tbl_education_resource|tbl_feedback|tbl_goals_concern|tbl_import_excel|tbl_life_changes|tbl_life_changes_options|tbl_long_term_goals|tbl_needs_assessment|tbl_note|tbl_payments|tbl_policies_in_place|tbl_policy_line_question|tbl_program_features|tbl_program_permission|tbl_promo|tbl_referral|tbl_reporting|tbl_security_group|tbl_staff_credits|tbl_top_concerns|tbl_top_concerns_options|tbl_user)\b/g ] };
jushLinks.bac = jushLinks.sql;
jushLinks.bra = jushLinks.sql;
jushLinks.sqlite_quo = jushLinks.sql;
jushLinks.mssql_bra = jushLinks.sql;
bodyLoad('5.5');
</script>
<form action="">
<p id="dbs">
<input type="hidden" name="username" value="root"><span title='database'>DB</span>: <select name='db' onmousedown='dbMouseDown(event, this);' onchange='dbChange(this);'><option value=""><option selected>agency_thrive_db<option>information_schema<option>mysql<option>performance_schema<option>phpmyadmin</select><input type='submit' value='Use' class='hidden'>
<input type="hidden" name="dump" value=""></p></form>
<p class='links'><a href='adminer.php?username=root&amp;db=agency_thrive_db&amp;sql='>SQL command</a>
<a href='adminer.php?username=root&amp;db=agency_thrive_db&amp;import='>Import</a>
<a href='adminer.php?username=root&amp;db=agency_thrive_db&amp;dump=' id='dump' class='active '>Export</a>
<a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;create=">Create table</a>
<ul id='tables' onmouseover='menuOver(this, event);' onmouseout='menuOut(this);'>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_02_models" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_02_models" class='structure' title='Show structure'>tbl_02_models</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_account_setup" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_account_setup" class='structure' title='Show structure'>tbl_account_setup</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_account_setup_policy" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_account_setup_policy" class='structure' title='Show structure'>tbl_account_setup_policy</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_action_item" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_action_item" class='structure' title='Show structure'>tbl_action_item</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_action_type" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_action_type" class='structure' title='Show structure'>tbl_action_type</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_activity_meta" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_activity_meta" class='structure' title='Show structure'>tbl_activity_meta</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_appointment" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_appointment" class='structure' title='Show structure'>tbl_appointment</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_audit_logs" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_audit_logs" class='structure' title='Show structure'>tbl_audit_logs</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_billing" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_billing" class='structure' title='Show structure'>tbl_billing</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_charges_fee" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_charges_fee" class='structure' title='Show structure'>tbl_charges_fee</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_ci_review" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_ci_review" class='structure' title='Show structure'>tbl_ci_review</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_client_resources" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_client_resources" class='structure' title='Show structure'>tbl_client_resources</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_colour_custom" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_colour_custom" class='structure' title='Show structure'>tbl_colour_custom</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_colour_scheme" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_colour_scheme" class='structure' title='Show structure'>tbl_colour_scheme</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_credit_card_settings" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_credit_card_settings" class='structure' title='Show structure'>tbl_credit_card_settings</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_current_coverage" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_current_coverage" class='structure' title='Show structure'>tbl_current_coverage</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_customer" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_customer" class='structure' title='Show structure'>tbl_customer</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_dependent" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_dependent" class='structure' title='Show structure'>tbl_dependent</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_education" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_education" class='structure' title='Show structure'>tbl_education</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_education_resource" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_education_resource" class='structure' title='Show structure'>tbl_education_resource</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_feedback" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_feedback" class='structure' title='Show structure'>tbl_feedback</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_goals_concern" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_goals_concern" class='structure' title='Show structure'>tbl_goals_concern</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_import_excel" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_import_excel" class='structure' title='Show structure'>tbl_import_excel</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_life_changes" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_life_changes" class='structure' title='Show structure'>tbl_life_changes</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_life_changes_options" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_life_changes_options" class='structure' title='Show structure'>tbl_life_changes_options</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_long_term_goals" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_long_term_goals" class='structure' title='Show structure'>tbl_long_term_goals</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_needs_assessment" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_needs_assessment" class='structure' title='Show structure'>tbl_needs_assessment</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_note" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_note" class='structure' title='Show structure'>tbl_note</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_payments" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_payments" class='structure' title='Show structure'>tbl_payments</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_policies_in_place" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_policies_in_place" class='structure' title='Show structure'>tbl_policies_in_place</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_policy_line_question" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_policy_line_question" class='structure' title='Show structure'>tbl_policy_line_question</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_program_features" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_program_features" class='structure' title='Show structure'>tbl_program_features</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_program_permission" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_program_permission" class='structure' title='Show structure'>tbl_program_permission</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_promo" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_promo" class='structure' title='Show structure'>tbl_promo</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_referral" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_referral" class='structure' title='Show structure'>tbl_referral</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_reporting" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_reporting" class='structure' title='Show structure'>tbl_reporting</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_security_group" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_security_group" class='structure' title='Show structure'>tbl_security_group</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_staff_credits" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_staff_credits" class='structure' title='Show structure'>tbl_staff_credits</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_top_concerns" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_top_concerns" class='structure' title='Show structure'>tbl_top_concerns</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_top_concerns_options" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_top_concerns_options" class='structure' title='Show structure'>tbl_top_concerns_options</a>
<li><a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;select=tbl_user" class='select'>select</a> <a href="adminer.php?username=root&amp;db=agency_thrive_db&amp;table=tbl_user" class='structure' title='Show structure'>tbl_user</a>
</ul>
</div>
<script type="text/javascript">setupSubmitHighlight(document);</script>
