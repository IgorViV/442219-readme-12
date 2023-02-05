<?php
/**
 * Part of the file upload form
 * Displays the file fields (dropzone.js) of the form
 */
?>
<div class="registration__input-file-container form__input-container form__input-container--file">
    <div class="registration__input-file-wrapper form__input-file-wrapper">
        <div class="registration__file-zone form__file-zone dropzone">
            <input class="registration__input-file form__input-file" id="file" type="file"
                   name="file" title=" ">
            <div class="form__file-zone-text">
                <span>Перетащите фото сюда</span>
            </div>
        </div>
        <button class="registration__input-file-button form__input-file-button button" type="button">
            <span>Выбрать фото</span>
            <svg class="registration__attach-icon form__attach-icon" width="10" height="20">
                <use xlink:href="#icon-attach"></use>
            </svg>
        </button>
    </div>
    <div class="registration__file form__file dropzone-previews">

    </div>
</div>
