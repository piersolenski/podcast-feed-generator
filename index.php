<?php
// Settings
$folder = "audio";
$thumbnail = "https://is4-ssl.mzstatic.com/image/thumb/Purple118/v4/9f/81/6b/9f816bf4-21bd-e275-40bf-568fee131baf/mzl.spoleoyd.png/246x0w.jpg";
// Setup
header('Content-Type: application/xml; charset=utf-8');
date_default_timezone_set('UTC');
echo '<?xml version="1.0" encoding="utf-8" ?>';
// Get files
$files = array();
foreach (glob("$folder/*.mp3") as $file) {
  $files[] = $file;
}
// Set protocol
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
  $protocol = 'http://';
} else {
  $protocol = 'https://';
}
// Get base URL
$base_url = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "/";
?>

<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
  <channel>
    <title>pogCast</title>
    <description>A podcast feed generated from <?php echo $base_url; ?></description>
    <link><?php echo $base_url; ?></link>
    <language>en-uk</language>
    <itunes:image href="<?php echo $thumbnail; ?>" />

    <?php foreach ($files as $key => $value):
      $encoded_url = str_replace("%2F", "/", rawurlencode($value));
    ?>
      <item>
        <title><?php echo basename($value, ".mp3") ?></title>
        <description><?php echo basename($value, ".mp3") ?></description>
        <enclosure url="<?php echo $base_url . $encoded_url ?>" length="<?php echo filesize($value); ?>" type="audio/mpeg"/>
        <pubDate><?php echo date("r", filemtime($value)); ?></pubDate>
      </item>
    <?php endforeach; ?>

  </channel>
</rss>
