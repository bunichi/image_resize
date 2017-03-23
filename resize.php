<?php
/*** define ***/
// 出力画像サイズ
define('OUTSIZE', 227);

// JPG画像圧縮度
define('JPG_QUALITY', 75);

// 入力ディレクトリ
define('INDIR', '../images_trim2/');

// 出力ディレクトリ
define('OUTDIR', './');
/**************/

$dirs = scandir(INDIR);
$new_dir = OUTDIR . time() . 'resized/';
print($new_dir . ' に画像を出力します');
exec('mkdir -p ' . $new_dir);
foreach($dirs as $dir){
	if( ($dir != '.') && ($dir != '..') && !strpos($dir, '.')){
		print("\n" . $new_dir . $dir . ' に画像出力中');
		$files = scandir(INDIR . $dir);

		if( count($files) ){
			foreach($files as $file){
				if(strpos($file, '.jpg') || strpos($file, '.png')){
					exec('mkdir -p ' . $new_dir . $dir);
					$new_file = $new_dir . $dir . '/' . $file;
					$old_file = INDIR . $dir . '/' . $file;
					$image_size = getimagesize($old_file);
					$width = $image_size[0];
					$height = $image_size[1];

					// 短い辺を基準にする
					if($width > $height){
						$source = $height;
						$pos_x = ($width - $height) / 2;
						$pos_y = 0;
					}else{
						$source = $width;
						$pos_x = 0;
                        $pos_y = ($height - $width) / 2;
					}

					// 画像のトリミングとリサイズを行う
					$rect = imagecreatetruecolor(OUTSIZE, OUTSIZE);
					$old_image = imagecreatefromstring(file_get_contents($old_file));
					if(!imagecopyresampled($rect, $old_image, 0, 0, $pos_x, $pos_y, OUTSIZE, OUTSIZE, $source, $source)){
						print($old_image . ' の画像リサンプリングに失敗しました');
					}

					// 元の画像形式に合わせてファイル出力
					if(strpos($file, '.jpg')){
						imagejpeg($rect, $new_file, JPG_QUALITY);
					}else if(strpos($file, '.png')){
						imagepng($rect, $new_file);
					}else{
						print("サポートされていない画像形式です");
					}
					echo('-');
				}
			}
		}
	}
}
