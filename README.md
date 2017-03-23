# image_resize
複数の画像ファイルを正方形にリサイズするプログラムです。
画像の中心を基準に、トリミングを行って正方形にし、アスペクト比を保ってリサイズします。
サポートする画像形式はpngまたはjpgのみです。
ディレクトリ1階層分だけ掘り進んでリサイズします。（INDIRの直下にある画像はリサイズ対象外で、INDIR/ANYDIR/any_image.jpg がリサイズ対象です）

・使い方
$ php resize.php

・リサイズ後の画像サイズは resize.php の以下の箇所を好きな値に変更可能です。
define('OUTSIZE', 227);

・入力画像の置き場所を resize.php の以下で設定し直してください。resize.php の置いてあるディレクトリが基準になります。
define('INDIR', '../images_trim2/');

・リサイズ後の画像は、配置ディレクトリ名、ファイル名、ファイル形式を保って以下に出力されます。
入力：INDIR/ANYDIR/any_image.jpg
出力：OUTDIR/{time}resized/ANYDIR/any_image.jpg
出力先ディレクトリを変更する場合、resize.php の以下を編集してください。
define('OUTDIR', './');
