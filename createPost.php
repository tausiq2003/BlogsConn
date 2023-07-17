<?php include "dbLogic.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location: home.php");
    exit();
}

?>
<?php require_once('partials/header.php') ?>

<link rel="stylesheet" href="static/css/style.css?v=<?php echo time(); ?>">
<link rel="icon" type="image/x-icon" href="/static/icons/logo.ico">
<title>BlogsConn - Create</title>
</head>

<body>

    <!-- Navbar -->
    <?php include('partials/navbar.php') ?>
    <?php include('partials/menuLinks.php') ?>
    <?php 
    $category = array("travel", "food", "lifestyle", "health", "wellness", "fashion", "beauty", "personaldevelopment", "parenting", "education", "sports", "music", "film", "television", "art", "photography", "homedecor", "diy", "crafts", "finance", "career", "relationships", "mindfulness", "selfcare", "productivity", "organization", "fitness", "nutrition", "meditation", "spirituality", "books", "gardening", "pets", "outdoors", "adventure", "gaming", "history", "architecture", "marketing", "socialmedia", "influencermarketing", "branding", "publicrelations", "entrepreneurship",
  "smallbusiness", "e-commerce", "sales", "customerexperience", "projectmanagement", "leadership", "teambuilding", "communication", "conflictresolution", "negotiation", "time-management", "eventplanning", "weddings", "interior design", "landscaping", "homeimprovement", "renewableenergy", "climatechange", "sustainability", "environmentalism", "philanthropy", "non-profit",
  "volunteering", "mentalhealth", "therapy", "addictionrecovery", "softwaredevelopment", "programminglanguages", "webdesign", "webdevelopment", "mobileappdevelopment", "gamedevelopment",
  "cybersecurity", "blockchain", "cloudcomputing", "artificialintelligence", "machinelearning", "robotics", "virtualreality", "augmentedreality", "internetofthings", "bigdata", "datascience",
  "dataanalytics", "fintech", "edtech", "nanotechnology", "healthcaretechnology", "legaltechnology", "transportationtechnology", "agriculturaltechnology", "manufacturingtechnology",  "constructiontechnology", "retailtechnology", "hospitalitytechnology", "spaceexplorationtechnology");
    ?>

    <div class='create-post'>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" class='create-post-title' placeholder="Blog Title" autocomplete="off"
                required>
            <select name="blog__topic" class="create-post-title" placeholder="Blog Category" required>
                <option value="" disabled selected>Blog Category</option>
                <?php foreach($category as $cat){ ?>
                <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                <?php
                    if(isset($_POST['new_post'])){
                        if(!in_array($_POST['blog__topic'], $category)){
                            echo "<script>alert('Invalid Category');</script>";
                        }
                    }
                ?>
                <?php } ?>
                
            </select>
            <input type="file" name="blog__img" class="blog-image" required>
            <textarea id='editor' name='editor1'rows="30">
                
</textarea>
            <input type='text' hidden name="userId" value="<?php echo $_SESSION['uid']; ?>">
            <button name="new_post" id='add-post-btn'>Add Post</button>
        </form>
    </div>


    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/super-build/ckeditor.js"></script>
    <script>
        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        CKEDITOR.ClassicEditor.create(document.getElementById("editor"), {
            // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
            toolbar: {
                items: [
                    'exportPDF', 'exportWord', '|',
                    'findAndReplace', 'selectAll', '|',
                    'heading', '|',
                    'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                    'bulletedList', 'numberedList', 'todoList', '|',
                    'outdent', 'indent', '|',
                    'undo', 'redo',
                    '-',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                    'alignment', '|',
                    'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed', '|',
                    'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                    'textPartLanguage', '|',
                    'sourceEditing'
                ],
                shouldNotGroupWhenFull: true
            },
            // Changing the language of the interface requires loading the language file using the <script> tag.
            // language: 'es',
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                ]
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
            placeholder: 'Write your thoughts....',
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
            fontFamily: {
                options: [
                    'default',
                    'Arial, Helvetica, sans-serif',
                    'Courier New, Courier, monospace',
                    'Georgia, serif',
                    'Lucida Sans Unicode, Lucida Grande, sans-serif',
                    'Tahoma, Geneva, sans-serif',
                    'Times New Roman, Times, serif',
                    'Trebuchet MS, Helvetica, sans-serif',
                    'Verdana, Geneva, sans-serif'
                ],
                supportAllValues: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
            fontSize: {
                options: [10, 12, 14, 'default', 18, 20, 22],
                supportAllValues: true
            },
            // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
            // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }
                ]
            },
            // Be careful with enabling previews
            // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
            htmlEmbed: {
                showPreviews: true
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
            link: {
                decorators: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
                    toggleDownloadable: {
                        mode: 'manual',
                        label: 'Downloadable',
                        attributes: {
                            download: 'file'
                        }
                    }
                }
            },
            // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
            mention: {
                feeds: [
                    {
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }
                ]
            },
            // The "super-build" contains more premium features that require additional configuration, disable them below.
            // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
            removePlugins: [
                // These two are commercial, but you can try them out without registering to a trial.
                // 'ExportPdf',
                // 'ExportWord',
                'CKBox',
                'CKFinder',
                'EasyImage',
                // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                // Storing images as Base64 is usually a very bad idea.
                // Replace it on production website with other solutions:
                // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                // 'Base64UploadAdapter',
                'RealTimeCollaborativeComments',
                'RealTimeCollaborativeTrackChanges',
                'RealTimeCollaborativeRevisionHistory',
                'PresenceList',
                'Comments',
                'TrackChanges',
                'TrackChangesData',
                'RevisionHistory',
                'Pagination',
                'WProofreader',
                // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                'MathType',
                // The following features are part of the Productivity Pack and require additional license.
                'SlashCommand',
                'Template',
                'DocumentOutline',
                'FormatPainter',
                'TableOfContents'
            ]
        });
    </script>
</body>
<?php require_once('partials/footer.php') ?>

</html>