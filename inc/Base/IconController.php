<?php
/**
 * Icon ctrl. Adapted from twentytwentytheme's icon system.
 *
 * @package easy-resources-page
 * @version 1.0.0
 */

namespace EasyResourcesPage\Base;

/**
 * About class.
 */
class IconController {

	/**
	 * Return svg for an icon name. Return default file svg if icon name is not on the list.
	 *
	 * @param string $icon Icon name.
	 */
	public static function get_svg_by_icon_name( $icon ) {

		$arr = self::$svg_icon_list;
		if ( false === array_key_exists( $icon, $arr ) ) {
			$icon = 'application'; // default file icon.
		}
			$repl = '<svg class="svg-icon" aria-hidden="true" role="img" focusable="false" ';
			$svg  = preg_replace( '/^<svg /', $repl, trim( $arr[ $icon ] ) ); // Add extra attributes to SVG code.
			$svg  = str_replace( '#', '%23', $svg ); // Urlencode hashes.
			$svg  = preg_replace( "/([\n\t]+)/", ' ', $svg ); // Remove newlines & tabs.
			$svg  = preg_replace( '/>\s*</', '><', $svg ); // Remove white space between SVG tags.
			return $svg;
	}

	/**
	 * Echos appropiate svg code for a mime type
	 *
	 * @param String $mime_type attachment mime type.
	 */
	public static function get_svg_by_mime_type( $mime_type ) {
		if ( array_key_exists( $mime_type, self::$map_mime_type_to_icon_name ) ) {
			$icon_name = self::$map_mime_type_to_icon_name[ $mime_type ];
		} else {
			$icon_name = 'application';
		}

		// Make sure that only our allowed tags and attributes are included.
		$svg = wp_kses(
			self::get_svg_by_icon_name( $icon_name ),
			array(
				'svg'     => array(
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true,
				),
				'path'    => array(
					'fill'      => true,
					'fill-rule' => true,
					'd'         => true,
					'transform' => true,
				),
				'polygon' => array(
					'fill'      => true,
					'fill-rule' => true,
					'points'    => true,
					'transform' => true,
					'focusable' => true,
				),
			)
		);

		if ( ! $svg ) {
			echo '';
		}

		// @codingStandardsIgnoreLine -- see wp_kses
		echo $svg; 
	}

	/**
	 * List of available svgs with code.
	 *
	 * @var array
	 */
	public static $svg_icon_list = array(
		'chevron-down'           => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="12" viewBox="0 0 20 12">
		<polygon fill="#444242" fill-rule="evenodd" points="1319.899 365.778 1327.678 358 1329.799 360.121 1319.899 370.021 1310 360.121 1312.121 358" transform="translate(-1310 -358)"/>
		</svg>',
		'chevron-up'             => '<svg width="20" height="12" viewBox="0 0 20 12" version="1.1" id="svg4">
			<path transform="matrix(1,0,0,-1,-1310,370.021)" id="polygon2" fill="#1a1a1b" fill-rule="evenodd" d="M1327.678 358l2.121 2.121-9.9 9.9-9.899-9.9 2.121-2.121 7.778 7.778z"/>
		</svg>',
		'image'                  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM96 224c17.67 0 32 14.33 32 32S113.7 288 96 288S64 273.7 64 256S78.33 224 96 224zM318.1 439.5C315.3 444.8 309.9 448 304 448h-224c-5.9 0-11.32-3.248-14.11-8.451c-2.783-5.201-2.479-11.52 .7949-16.42l53.33-80C122.1 338.7 127.1 336 133.3 336s10.35 2.674 13.31 7.125L160 363.2l45.35-68.03C208.3 290.7 213.3 288 218.7 288s10.35 2.674 13.31 7.125l85.33 128C320.6 428 320.9 434.3 318.1 439.5zM256 0v128h128L256 0z"/></svg>',
		'video'                  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM224 384c0 17.67-14.33 32-32 32H96c-17.67 0-32-14.33-32-32V288c0-17.67 14.33-32 32-32h96c17.67 0 32 14.33 32 32V384zM320 284.9v102.3c0 12.57-13.82 20.23-24.48 13.57L256 376v-80l39.52-24.7C306.2 264.6 320 272.3 320 284.9z"/></svg>',
		'audio'                  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM176 404c0 10.75-12.88 15.98-20.5 8.484L120 376H76C69.38 376 64 370.6 64 364v-56C64 301.4 69.38 296 76 296H120l35.5-36.5C163.1 251.9 176 257.3 176 268V404zM224 387.8c-4.391 0-8.75-1.835-11.91-5.367c-5.906-6.594-5.359-16.69 1.219-22.59C220.2 353.7 224 345.2 224 336s-3.797-17.69-10.69-23.88c-6.578-5.906-7.125-16-1.219-22.59c5.922-6.594 16.05-7.094 22.59-1.219C248.2 300.5 256 317.8 256 336s-7.766 35.53-21.31 47.69C231.6 386.4 227.8 387.8 224 387.8zM320 336c0 41.81-20.5 81.11-54.84 105.1c-2.781 1.938-5.988 2.875-9.145 2.875c-5.047 0-10.03-2.375-13.14-6.844c-5.047-7.25-3.281-17.22 3.969-22.28C272.6 396.9 288 367.4 288 336s-15.38-60.84-41.14-78.8c-7.25-5.062-9.027-15.03-3.98-22.28c5.047-7.281 14.99-9.062 22.27-3.969C299.5 254.9 320 294.2 320 336zM256 0v128h128L256 0z"/></svg>',
		'text'                   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 64C0 28.65 28.65 0 64 0H224V128C224 145.7 238.3 160 256 160H384V299.6L289.3 394.3C281.1 402.5 275.3 412.8 272.5 424.1L257.4 484.2C255.1 493.6 255.7 503.2 258.8 512H64C28.65 512 0 483.3 0 448V64zM256 128V0L384 128H256zM564.1 250.1C579.8 265.7 579.8 291 564.1 306.7L534.7 336.1L463.8 265.1L493.2 235.7C508.8 220.1 534.1 220.1 549.8 235.7L564.1 250.1zM311.9 416.1L441.1 287.8L512.1 358.7L382.9 487.9C378.8 492 373.6 494.9 368 496.3L307.9 511.4C302.4 512.7 296.7 511.1 292.7 507.2C288.7 503.2 287.1 497.4 288.5 491.1L303.5 431.8C304.9 426.2 307.8 421.1 311.9 416.1V416.1z"/></svg>',
		'application'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M0 64C0 28.65 28.65 0 64 0H224V128C224 145.7 238.3 160 256 160H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64zM256 128V0L384 128H256z"/></svg>',
		'application-pdf'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M88 304H80V256H88C101.3 256 112 266.7 112 280C112 293.3 101.3 304 88 304zM192 256H200C208.8 256 216 263.2 216 272V336C216 344.8 208.8 352 200 352H192V256zM224 0V128C224 145.7 238.3 160 256 160H384V448C384 483.3 355.3 512 320 512H64C28.65 512 0 483.3 0 448V64C0 28.65 28.65 0 64 0H224zM64 224C55.16 224 48 231.2 48 240V368C48 376.8 55.16 384 64 384C72.84 384 80 376.8 80 368V336H88C118.9 336 144 310.9 144 280C144 249.1 118.9 224 88 224H64zM160 368C160 376.8 167.2 384 176 384H200C226.5 384 248 362.5 248 336V272C248 245.5 226.5 224 200 224H176C167.2 224 160 231.2 160 240V368zM288 224C279.2 224 272 231.2 272 240V368C272 376.8 279.2 384 288 384C296.8 384 304 376.8 304 368V320H336C344.8 320 352 312.8 352 304C352 295.2 344.8 288 336 288H304V256H336C344.8 256 352 248.8 352 240C352 231.2 344.8 224 336 224H288zM256 0L384 128H256V0z"/></svg>',
		'application-zip'        => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM96 32h64v32H96V32zM96 96h64v32H96V96zM96 160h64v32H96V160zM128.3 415.1c-40.56 0-70.76-36.45-62.83-75.45L96 224h64l30.94 116.9C198.7 379.7 168.5 415.1 128.3 415.1zM144 336h-32C103.2 336 96 343.2 96 352s7.164 16 16 16h32C152.8 368 160 360.8 160 352S152.8 336 144 336z"/></svg>',
		'application-word'       => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM281.5 240h23.37c7.717 0 13.43 7.18 11.69 14.7l-42.46 184C272.9 444.1 268 448 262.5 448h-29.26c-5.426 0-10.18-3.641-11.59-8.883L192 329.1l-29.61 109.1C160.1 444.4 156.2 448 150.8 448H121.5c-5.588 0-10.44-3.859-11.69-9.305l-42.46-184C65.66 247.2 71.37 240 79.08 240h23.37c5.588 0 10.44 3.859 11.69 9.301L137.8 352L165.6 248.9C167 243.6 171.8 240 177.2 240h29.61c5.426 0 10.18 3.641 11.59 8.883L246.2 352l23.7-102.7C271.1 243.9 275.1 240 281.5 240zM256 0v128h128L256 0z"/></svg>',
		'application-excel'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM272.1 264.4L224 344l48.99 79.61C279.6 434.3 271.9 448 259.4 448h-26.43c-5.557 0-10.71-2.883-13.63-7.617L192 396l-27.31 44.38C161.8 445.1 156.6 448 151.1 448H124.6c-12.52 0-20.19-13.73-13.63-24.39L160 344L111 264.4C104.4 253.7 112.1 240 124.6 240h26.43c5.557 0 10.71 2.883 13.63 7.613L192 292l27.31-44.39C222.2 242.9 227.4 240 232.9 240h26.43C271.9 240 279.6 253.7 272.1 264.4zM256 0v128h128L256 0z"/></svg>',
		'application-powerpoint' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM279.6 308.1C284.2 353.5 248.5 392 204 392H160v40C160 440.8 152.8 448 144 448H128c-8.836 0-16-7.164-16-16V256c0-8.836 7.164-16 16-16h71.51C239.3 240 275.6 268.5 279.6 308.1zM160 344h44c15.44 0 28-12.56 28-28S219.4 288 204 288H160V344z"/></svg>',
	);

	/**
	 * By mime
	 *
	 * @var array
	 */
	public static $map_mime_type_to_icon_name = array(
		'image/jpeg'                                       => 'image',
		'image/gif'                                        => 'image',
		'image/png'                                        => 'image',
		'image/bmp'                                        => 'image',
		'image/tiff'                                       => 'image',
		'image/webp'                                       => 'image',
		'image/x-icon'                                     => 'image',
		'image/heic'                                       => 'image',
		'video/x-ms-asf'                                   => 'video',
		'video/x-ms-wmv'                                   => 'video',
		'video/x-ms-wmx'                                   => 'video',
		'video/x-ms-wm'                                    => 'video',
		'video/avi'                                        => 'video',
		'video/divx'                                       => 'video',
		'video/x-flv'                                      => 'video',
		'video/quicktime'                                  => 'video',
		'video/mpeg'                                       => 'video',
		'video/mp4'                                        => 'video',
		'video/ogg'                                        => 'video',
		'video/webm'                                       => 'video',
		'video/x-matroska'                                 => 'video',
		'video/3gpp'                                       => 'video',
		'video/3gpp2'                                      => 'video',
		'text/plain'                                       => 'text',
		'text/csv'                                         => 'text',
		'text/tab-separated-values'                        => 'text',
		'text/calendar'                                    => 'text',
		'text/richtext'                                    => 'text',
		'text/css'                                         => 'text',
		'text/html'                                        => 'text',
		'text/vtt'                                         => 'text',
		'application/ttaf+xml'                             => 'application',
		'audio/mpeg'                                       => 'audio',
		'audio/aac'                                        => 'audio',
		'audio/x-realaudio'                                => 'audio',
		'audio/wav'                                        => 'audio',
		'audio/ogg'                                        => 'audio',
		'audio/flac'                                       => 'audio',
		'audio/midi'                                       => 'audio',
		'audio/x-ms-wma'                                   => 'audio',
		'audio/x-ms-wax'                                   => 'audio',
		'audio/x-matroska'                                 => 'audio',
		'application/rtf'                                  => 'application',
		'application/javascript'                           => 'application',
		'application/pdf'                                  => 'application-pdf',
		'application/java'                                 => 'application',
		'application/x-tar'                                => 'application-zip',
		'application/zip'                                  => 'application-zip',
		'application/x-gzip'                               => 'application-zip',
		'application/rar'                                  => 'application-zip',
		'application/x-7z-compressed'                      => 'application-zip',
		'application/octet-stream'                         => 'application',
		'application/octet-stream'                         => 'application',
		'application/msword'                               => 'application-word',
		'application/vnd.ms-powerpoint'                    => 'application-powerpoint',
		'application/vnd.ms-write'                         => 'application',
		'application/vnd.ms-excel'                         => 'application-excel',
		'application/vnd.ms-access'                        => 'application',
		'application/vnd.ms-project'                       => 'application',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'application',
		'application/vnd.ms-word.document.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => 'application',
		'application/vnd.ms-word.template.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'application',
		'application/vnd.ms-excel.sheet.macroEnabled.12'   => 'application',
		'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => 'application',
		'application/vnd.ms-excel.template.macroEnabled.12' => 'application',
		'application/vnd.ms-excel.addin.macroEnabled.12'   => 'application',
		'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'application',
		'application/vnd.ms-powerpoint.presentation.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => 'application',
		'application/vnd.ms-powerpoint.slideshow.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.presentationml.template' => 'application',
		'application/vnd.ms-powerpoint.template.macroEnabled.12' => 'application',
		'application/vnd.ms-powerpoint.addin.macroEnabled.12' => 'application',
		'application/vnd.openxmlformats-officedocument.presentationml.slide' => 'application',
		'application/vnd.ms-powerpoint.slide.macroEnabled.12' => 'application',
		'application/onenote'                              => 'application',
		'application/oxps'                                 => 'application',
		'application/vnd.ms-xpsdocument'                   => 'application',
		'application/vnd.oasis.opendocument.text'          => 'application',
		'application/vnd.oasis.opendocument.presentation'  => 'application',
		'application/vnd.oasis.opendocument.spreadsheet'   => 'application',
		'application/vnd.oasis.opendocument.graphics'      => 'application',
		'application/vnd.oasis.opendocument.chart'         => 'application',
		'application/vnd.oasis.opendocument.database'      => 'application',
		'application/vnd.oasis.opendocument.formula'       => 'application',
		'application/wordperfect'                          => 'application',
		'application/vnd.apple.keynote'                    => 'application',
		'application/vnd.apple.numbers'                    => 'application',
		'application/vnd.apple.pages'                      => 'application',
	);





}
