/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.filebrowserImageUploadUrl= "/mall/editorup/editorup";
    config.filebrowserUploadUrl = '/mall/editorup/editorup';

    config.width = 730; //宽度
    config.height = 400; //高度
    config.paddingLeft = 92;
    config.paddingRight = 91;
    config.toolbar = 'Full';
    config.codeSnippet_theme = 'default';
    config.allowedContent= true; 
    //工具栏
    config.toolbar_Basic = [['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']];
    config.toolbar_Full =
        [
            ['Source'],['CodeSnippet'],['Link','Unlink','Anchor'],['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
            ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
            '/',
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['TextColor','BGColor'],['Styles','Format','FontSize'],['Bold','Italic','Underline','Strike','-'],
            ['Maximize', 'ShowBlocks','-']
        ];
};
