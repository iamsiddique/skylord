<?php
/**
 * @package WordPress
 * @subpackage Reales
 */
?>

<div class="submit_container">
    <div class="submit_container_header"><?php esc_html_e('Image Gallery', 'reales');?> <span class="text-red">*</span></div>
    <div id="upload-container">
        <div id="aaiu-upload-container">
            <div id="aaiu-upload-imagelist"></div>
            <div id="imagelist"></div>
            <div class="clearfix"></div>
            <a href="javascript:void(0);" id="aaiu-uploader" class="btn btn-o btn-default"><span class="glyphicon glyphicon-folder-open"></span>&nbsp;&nbsp;&nbsp;<?php _e('Browse Images', 'reales');?></a>
            <input type="hidden" name="new_gallery" id="new_gallery">
        </div>
    </div>
</div>