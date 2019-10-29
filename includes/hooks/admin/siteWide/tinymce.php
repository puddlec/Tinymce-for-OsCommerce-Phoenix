<?php
/*
  Copyright (c) 2019, C Poole
  All rights reserved.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

  1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.

  2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.

  3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/*
HOW TO USE
you can either load the js file needed for TinyMCE locally or via the TinyMCE CDN (if you have a api key
if using TinyMCE CDN
use the url proivded to you by TinyMCE

if loading tinymce locally
<script src="path/to/where/you/saved/it"></script>
I recommend using the TinyMCE CDN, as it will keep it up to date.

HOW TO ADD TO OTHER TEXTAREAS
You will need to add the name of the textera to the selector line 
e.g. if the textarea name is example_name[1] you need to put
, textarea[name^="example_name"]
it will then load it on all textareas with example_name so if you have a multi language store, it will load for all languages
if the textarea is not on the categories or manufacors page then you will neeed to add the filename to  the $good_pages variable

HOW TO ADD/RE,OVE PLUGINS AND WHAT APPEARS IN THE TOOLBARS
this is done by simply adding/removing stuff from the plugins or toolbar settings
it is just what i use personally

*/
class hook_admin_siteWide_tinymce {
  var $version = '1.0.3';
  
  var $sitestart = null;
  var $siteend = null;
  var $good_pages = ['categories.php', 'manufacturers.php']; // what pages do you want to load the tinymce editor on
  
  function listen_injectSiteEnd() {
    $this->siteend .= '<!-- tiny mce -->' . PHP_EOL;
    $this->siteend .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.15/tinymce.min.js"></script>' . PHP_EOL;
 $tinyScript = <<<eod
<script>
tinymce.init({
  selector: 'textarea[name^="products_description"], textarea[name^="categories_description"],  textarea[name^="manufacturers_description"]', // Select all textarea we want to use it on
  height: 500,
	forced_root_block : false,
  theme: 'silver',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc a11ychecker autosave'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor  | codesample fontselect fontsizeselect | a11ycheck restoredraft',
  image_advtab: true,
relative_urls : true,
remove_script_host : true,
  content_css: [
	'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css',
	'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css'
  ]
 });
</script>
eod;

if (in_array(basename($_SERVER['PHP_SELF']), $this->good_pages)) {	
 $this->siteend .= $tinyScript . PHP_EOL;
    return $this->siteend;
  }
 } 
}