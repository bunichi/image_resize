<?php
/*** define ***/
// 出力画像サイズ
define('OUTSIZE', 227);

// 入力ディレクトリ
define('INDIR', './images_trim2/');

// 出力ディレクトリ
define('OUTDIR', './');
/**************/
$dirs = scandir(INDIR);
$new_dir = OUTDIR . time() . 'resized';
print($new_dir . 'に画像を出力します');
exec('mkdir -p ' . $new_dir);
foreach($dirs as $dir){
	print("\n" . $dir . 'に画像出力中');
	if( ($dir != '.') && ($dir != '..') && !strpos($dir, '.')){
		$files = scandir(INDIR . $dir);

		if( count($files) ){
			foreach($files as $file){
				if(strpos($file, '.jpg') || strpos($file, '.png')){
					exec('mkdir -p ' . $new_dir . '/' . $dir);
					exec('mkdir -p ' . $new_dir . '/tmp');
					$new_file = $new_dir . '/' . $dir . '/' . $file;
					$old_file = INDIR . '/' . $dir . '/' . $file;
					$tmp_file = $new_dir . '/tmp/' . $file;

					$width = exec("identify -format '%w' " . $old_file);
					$height = exec("identify -format '%h' " . $old_file);

					// 短い辺を基準にして正方形にトリミング
					if($width > $height){
						$pos_x = ($width - $height) / 2;
						exec('convert -crop ' . $height . 'x' . $height . '+' . $pos_x . '+0 ' . $old_file . ' ' . $tmp_file);
					}else{
                        $pos_y = ($height - $width) / 2;
                        exec('convert -crop ' . $width . 'x' . $width . '+0+' . $pos_y . ' ' . $old_file . ' ' . $tmp_file);
					}

					// リサイズ
					exec('convert -resize ' . OUTSIZE . 'x' . OUTSIZE . ' ' . $tmp_file . ' ' . $new_file);
					exec('rm -r ' . $new_dir . '/tmp');
					echo('-');
				}
			}
		}
	}
}
