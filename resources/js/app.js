import './bootstrap';

import {
	ClassicEditor,
	AccessibilityHelp,
	Alignment,
	Autoformat,
	AutoImage,
	AutoLink,
	Autosave,
	BalloonToolbar,
	BlockQuote,
	BlockToolbar,
	Bold,
	CodeBlock,
	Essentials,
	FindAndReplace,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	FontSize,
	Heading,
	Highlight,
	HorizontalLine,
	HtmlEmbed,
	ImageBlock,
	ImageCaption,
	ImageInline,
	ImageInsert,
	ImageInsertViaUrl,
	ImageResize,
	ImageStyle,
	ImageTextAlternative,
	ImageToolbar,
	ImageUpload,
	Indent,
	IndentBlock,
	Italic,
	Link,
	LinkImage,
	List,
	ListProperties,
	MediaEmbed,
	Paragraph,
	PasteFromOffice,
	SelectAll,
	SimpleUploadAdapter,
	SourceEditing,
	SpecialCharacters,
	SpecialCharactersText,
	Table,
	TableCaption,
	TableCellProperties,
	TableColumnResize,
	TableProperties,
	TableToolbar,
	TextTransformation,
	TodoList,
	Underline,
	Undo
} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

import './style.css';

// cek apakah ada element dengan id formWithEditor
if (document.querySelector('#formWithEditor')) {
	let initialDataHtml = document.querySelector('#contentTarget').value;
	const editorConfig = {
		toolbar: {
			items: [
				'undo',
				'redo',
				'|',
				'sourceEditing',
				'findAndReplace',
				'selectAll',
				'|',
				'heading',
				'|',
				'fontSize',
				'fontFamily',
				'fontColor',
				'fontBackgroundColor',
				'|',
				'bold',
				'italic',
				'underline',
				'|',
				'specialCharacters',
				'horizontalLine',
				'link',
				'insertImage',
				'mediaEmbed',
				'insertTable',
				'highlight',
				'blockQuote',
				'codeBlock',
				'htmlEmbed',
				'|',
				'alignment',
				'|',
				'bulletedList',
				'numberedList',
				'todoList',
				'outdent',
				'indent',
				'|',
				'accessibilityHelp'
			],
			shouldNotGroupWhenFull: true
		},
		plugins: [
			AccessibilityHelp,
			Alignment,
			Autoformat,
			AutoImage,
			AutoLink,
			Autosave,
			BalloonToolbar,
			BlockQuote,
			BlockToolbar,
			Bold,
			CodeBlock,
			Essentials,
			FindAndReplace,
			FontBackgroundColor,
			FontColor,
			FontFamily,
			FontSize,
			Heading,
			Highlight,
			HorizontalLine,
			HtmlEmbed,
			ImageBlock,
			ImageCaption,
			ImageInline,
			ImageInsert,
			ImageInsertViaUrl,
			ImageResize,
			ImageStyle,
			ImageTextAlternative,
			ImageToolbar,
			ImageUpload,
			Indent,
			IndentBlock,
			Italic,
			Link,
			LinkImage,
			List,
			ListProperties,
			MediaEmbed,
			Paragraph,
			PasteFromOffice,
			SelectAll,
			SimpleUploadAdapter,
			SourceEditing,
			SpecialCharacters,
			SpecialCharactersText,
			Table,
			TableCaption,
			TableCellProperties,
			TableColumnResize,
			TableProperties,
			TableToolbar,
			TextTransformation,
			TodoList,
			Underline,
			Undo
		],
		extraPlugins: [
			CustomUploadAdapterPlugin,
		],
		balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],
		blockToolbar: [
			'fontSize',
			'fontColor',
			'fontBackgroundColor',
			'|',
			'bold',
			'italic',
			'|',
			'link',
			'insertImage',
			'insertTable',
			'|',
			'bulletedList',
			'numberedList',
			'outdent',
			'indent'
		],
		fontFamily: {
			supportAllValues: true
		},
		fontSize: {
			options: [10, 12, 14, 'default', 18, 20, 22],
			supportAllValues: true
		},
		heading: {
			options: [
				{
					model: 'paragraph',
					title: 'Paragraph',
					class: 'ck-heading_paragraph'
				},
				{
					model: 'heading1',
					view: 'h1',
					title: 'Heading 1',
					class: 'ck-heading_heading1'
				},
				{
					model: 'heading2',
					view: 'h2',
					title: 'Heading 2',
					class: 'ck-heading_heading2'
				},
				{
					model: 'heading3',
					view: 'h3',
					title: 'Heading 3',
					class: 'ck-heading_heading3'
				},
				{
					model: 'heading4',
					view: 'h4',
					title: 'Heading 4',
					class: 'ck-heading_heading4'
				},
				{
					model: 'heading5',
					view: 'h5',
					title: 'Heading 5',
					class: 'ck-heading_heading5'
				},
				{
					model: 'heading6',
					view: 'h6',
					title: 'Heading 6',
					class: 'ck-heading_heading6'
				}
			]
		},
		image: {
			toolbar: [
				'toggleImageCaption',
				'imageTextAlternative',
				'|',
				'imageStyle:inline',
				'imageStyle:wrapText',
				'imageStyle:breakText',
				'|',
				'resizeImage'
			]
		},
		initialData: initialDataHtml,
		link: {
			addTargetToExternalLinks: true,
			defaultProtocol: 'https://',
			decorators: {
				toggleDownloadable: {
					mode: 'manual',
					label: 'Downloadable',
					attributes: {
						download: 'file'
					}
				}
			}
		},
		list: {
			properties: {
				styles: true,
				startIndex: true,
				reversed: true
			}
		},
		placeholder: 'Type or paste your content here!',
		table: {
			contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
		}
	};
	let ckeditorobj;
	 ClassicEditor.create(document.querySelector('#editor'), editorConfig)
												.then(editor => {
													ckeditorobj = editor;
												}).catch(error => {
													console.error(error);
												});
	class CustomUploadAdapter {
		constructor(loader) {
			// The file loader instance to use during the upload.
			this.loader = loader;
		}
		
		// Starts the upload process.
		upload() {
			return this.loader.file
			.then(file => new Promise((resolve, reject) => {
				this._initRequest();
				this._initListeners(resolve, reject, file);
				this._sendRequest(file);
			}));
		}
		
		// Aborts the upload process.
		abort() {
			if (this.xhr) {
				this.xhr.abort();
			}
		}
		
		_initRequest() {
			const xhr = this.xhr = new XMLHttpRequest();
			xhr.open('POST', '/upload', true);
			xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
			xhr.responseType = 'json';
		}
		
		_initListeners(resolve, reject, file) {
			const xhr = this.xhr;
			const loader = this.loader;
			const genericErrorText = `Couldn't upload file: ${file.name}.`;
			
			xhr.addEventListener('error', () => reject(genericErrorText));
			xhr.addEventListener('abort', () => reject());
			xhr.addEventListener('load', () => {
				const response = xhr.response;
				
				if (!response || response.error) {
					return reject(response && response.error ? response.error.message : genericErrorText);
				}
				
				resolve({
					default: response.url
				});
			});
			
			if (xhr.upload) {
				xhr.upload.addEventListener('progress', evt => {
					if (evt.lengthComputable) {
						loader.uploadTotal = evt.total;
						loader.uploaded = evt.loaded;
					}
				});
			}
		}
		
		_sendRequest(file) {
			const data = new FormData();
			const csrfToken = document.head.querySelector("[name~=csrf_token][content]").content;
			data.append('upload', file);
			data.append('_token', csrfToken);
			this.xhr.send(data);
		}
	}
	
	function CustomUploadAdapterPlugin(editor) {
		editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
			return new CustomUploadAdapter(loader);
		};
	}
	
	document.querySelector('#image').addEventListener('change', function () {
		const reader = new FileReader();
		reader.onload = function (e) {
			document.querySelector('#imagePreview').src = e.target.result;
		};
		reader.readAsDataURL(this.files[0]);
	});
	
	document.getElementById('formWithEditor').addEventListener('submit', function(event) {
		event.preventDefault();
		const content = ckeditorobj.getData();
		const contentTargetField = document.getElementById('contentTarget');
		contentTargetField.setAttribute('value', content);
		this.submit();
	});
}


