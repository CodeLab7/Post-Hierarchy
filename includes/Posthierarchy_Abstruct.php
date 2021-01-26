<?php

class Posthierarchy_Abstruct {
	protected $plugin_name = 'Post Hierarchy';
	protected $text_domain = 'post-hierarchy';
	protected $version = POSTHIERARCHY_VERSION;

	protected function error_on() {
		ini_set( 'display_errors', '1' );
		ini_set( 'display_startup_errors', '1' );
		error_reporting( E_ALL );
	}

	protected function dump( $data ) {
		if ( is_object( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-object">OBJECT</span>';
		}
		elseif ( is_array( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-array">ARRAY</span>';
		}
		elseif ( is_string( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-string">STRING</span>';
		}
		elseif ( is_int( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-integer">INTEGER</span>';
		}
		elseif ( is_null( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-null">NULL</span>';
		}
		elseif ( is_float( $data ) ) {
			$message = '<span class="codelab7-debug-badge codelab7-debug-badge-float">FLOAT</span>';
		}
		else {
			$message = 'N/A';
		}
		$output = '<div style="clear:both;"></div>';
		$output .= '<meta charset="UTF-8" />';
		$output .= '<style>body{margin:0}::selection{background-color:#E13300!important;color:#fff} --moz-selection{background-color:#E13300!important;color:#fff}--webkit-selection{background-color:#E13300!important;color:#fff}div.debugbody{background-color:#fff;margin:0px;font:9px/12px normal;font-family:Arial,Helvetica,sans-serif;color:#4F5155;min-width:500px}a.debughref{color:#039;background-color:transparent;font-weight:400}h1.debugheader{color:#444;background-color:transparent;border-bottom:1px solid #D0D0D0;font-size:12px;line-height:14px;font-weight:700;margin:0 0 14px;padding:14px 15px 10px;font-family:\'Ubuntu Mono\',Consolas}code.debugcode{font-family:\'Ubuntu Mono\',Consolas,Monaco,Courier New,Courier,monospace;font-size:12px;background-color:#f9f9f9;border:1px solid #D0D0D0;color:#002166;display:block;margin:10px 0;padding:5px 10px 15px}code.debugcode.debug-last-query{display:none}pre.debugpre{display:block;padding:0;margin:0;color:#002166;font:12px/14px normal;font-family:\'Ubuntu Mono\',Consolas,Monaco,Courier New,Courier,monospace;background:0;border:0}div.debugcontent{margin:0 15px}p.debugp{margin:0;padding:0}.debugitalic{font-style:italic}.debutextR{text-align:right;margin-bottom:0;margin-top:0}.debugbold{font-weight:700}p.debugfooter{text-align:right;font-size:11px;border-top:1px solid #D0D0D0;line-height:32px;padding:0 10px;margin:20px 0 0}div.debugcontainer{margin:0px;border:1px solid #D0D0D0;-webkit-box-shadow:0 0 8px #D0D0D0}code.debug p{padding:0;margin:0;width:100%;text-align:right;font-weight:700;text-transform:uppercase;border-bottom:1px dotted #CCC;clear:right}code.debug span{float:left;font-style:italic;color:#CCC}.codelab7-debug-badge{background:#285AA5;border:1px solid rgba(0,0,0,0);border-radius:4px;color:#FFF;padding:2px 4px}.codelab7-debug-badge-object{background:#A53C89}.codelab7-debug-badge-array{background:#037B5A}.codelab7-debug-badge-string{background:#037B5A}.codelab7-debug-badge-integer{background:#552EF3}.codelab7-debug-badge-true{background:#126F0B}.codelab7-debug-badge-false{background:#DE0303}.codelab7-debug-badge-null{background:#383838}.codelab7-debug-badge-float{background:#9E4E09}p.debugp.debugbold.debutextR.lq-trigger:hover + code{display:block}</style>';
		$output .= '<div class="debugbody"><div class="debugcontainer">';
		$output .= '<div class="debugcontent">';
		$output .= '<code class="debugcode"><p class="debugp debugbold debutextR">:: print_r</p><pre class="debugpre">' . $message;
		ob_start();
		print_r( $data );
		$output .= "\n\n" . trim( ob_get_clean() );
		$output .= '</pre></code></div><p class="debugfooter">Debugger &copy; codeLab7</p></div></div><div style="clear:both;"></div>';
		echo $output;
	}

	protected function dd( $data ) {
		$this->dump( $data );
		wp_die();
	}

	protected function _clean_varname( $variablename, $sep = '_') {
		$variablename = str_replace( " ", $sep , strtolower( $variablename ) );

		return preg_replace( '/[^A-Za-z0-9_\-]/', '', $variablename );
	}

}
