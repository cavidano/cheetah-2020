<div class="wrap">
<div id="nsc_bar_upper_area">
<h1 id="nsc_bar_admin_title"><?php echo $objSettings->settings_page_configs->page_title ?></h1>
<p><?php echo $objSettings->settings_page_configs->description ?></p>
</div>
<h2 class="nav-tab-wrapper">
<?php
//tabs are created
foreach ($objSettings->setting_page_fields->tabs as $tab) {
    $activeTab = "";
    if ($tab->active === true) {
        $activeTab = 'nav-tab-active';
    }
    echo '<a href="?page=' . $objSettings->plugin_slug . '&tab=' . $tab->tab_slug . '&' . $objSettings->additional_tab_link_parameter . '" class="nav-tab ' . $activeTab . '" >' . $tab->tabname . '</a>';
}
$active_tab_index = $objSettings->setting_page_fields->active_tab_index;
?>
</h2>
<span id="nsc_settings_content">
<table class="form-table nsc_bar_language">
  <tbody>
    <tr id="tr_content_language_setter">
      <th scope="row">Language</th>
      <td>
        <fieldset>
          <label><?php echo $form_fields->nsc_bar_get_language_dropdown() ?></label>
          <p class="description"><?php echo $objSettings->addon_lang_description ?></p>
        </fieldset>
      </td>
    </tr>
  </tbody>
</table>

<?php echo $objSettings->setting_page_fields->tabs[$active_tab_index]->tab_description ?>
<form action="" method="post">
<?php
settings_fields($objSettings->plugin_slug . $objSettings->setting_page_fields->tabs[$active_tab_index]->tab_slug);
?>
<?php submit_button();?>

<table class="form-table">
<?php foreach ($objSettings->setting_page_fields->tabs[$active_tab_index]->tabfields as $field_configs) {?>
 <tr id="tr_<?php echo $field_configs->field_slug ?>">
  <th scope="row">
    <?php echo $field_configs->name ?>
  </th>
  <td>
    <fieldset>
      <?php echo $form_fields->nsc_bar_return_form_field($field_configs, $objSettings->plugin_prefix); ?>
      <?php if (!empty($field_configs->custom_component)) {echo $field_configs->custom_component;}?>
     <p class="description"><?php echo $field_configs->helpertext ?></p>
    </fieldset>
  </td>
 </tr>
<?php }?>
</table>
</form>
</span>
<?php require 'sidebar.php';?>


