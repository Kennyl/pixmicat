<?php
/*
Pixmicat! : 圖咪貓貼圖版程式
http://pixmicat.openfoundry.org/
版權所有 © 2005-2006 Pixmicat! Development Team

版權聲明：
此程式是基於レッツPHP!<http://php.s3.to/>的gazou.php、
雙葉<http://www.2chan.net>的futaba.php所改寫之衍生著作程式，屬於自由軟體，
以The Clarified Artistic License作為發佈授權條款。
您可以遵照The Clarified Artistic License來自由使用、散播、修改或製成衍生著作。
更詳細的條款及定義請參考隨附"LICENSE"條款副本。

發佈這一程式的目的是希望它有用，但沒有任何擔保，甚至沒有適合特定目的而隱含的擔保。
關於此程式相關的問題請不要詢問レッツPHP!及雙葉。

如果您沒有隨著程式收到一份The Clarified Artistic License副本，
請瀏覽http://pixmicat.openfoundry.org/license/以取得一份。
*/
/*---- Part 1：程式基本設定 ----*/
// 伺服器常態設定
define("PHP_SELF", basename($_SERVER["PHP_SELF"])); // 此程式名 (此欄不需修改)
define("TIME_ZONE", '+8'); // 時區設定 (GMT時區，參照 http://wwp.greenwichmeantime.com/ )
define("HTTP_UPLOAD_DIFF", 50); // HTTP上傳所有位元組與實際位元組之允許誤差值
ini_set("memory_limit", '32M'); // PHP運行的最大記憶體使用量 (php內定8M / 建議32M)

// FTP
define("USE_FTP", 0); // 使用FTP
define("FTP_HOST", 'ftp.t35.com'); // FTP主機地址
define("FTP_PORT", 21); // FTP主機連接埠
define("FTP_USER", 'demo.t35.com'); // FTP使用者用稱
define("FTP_PASS", 'demo'); // FTP使用者密碼
define("FTP_BASE_PATH", '/'); // FTP目錄
define("FTP_FILE_LOG", 'ftp.log'); // FTP記錄檔檔名

define("IMGLINK_URL_PREFIX",''); // 圖像連結(檔名部份)的前置路徑/URL, 不使用的話請設為''
define("IMG_URL_PREFIX",''); // 圖像連結(縮圖部份)的前置路徑/URL, 不使用的話請設為''
define("THUMB_URL_PREFIX",''); // 縮圖URL的前置路徑/URL, 不使用的話請設為''

// PIO
define("CONNECTION_STRING", 'log://img.log:tree.log/'); // PIO 連線字串
//define("CONNECTION_STRING", 'mysql://pixmicat:pass@127.0.0.1/test/imglog/'); // PIO 連線字串

/*---- Part 2：板面各項細部功能設定 ----*/
define("IMG_DIR", 'src/'); // 圖片存放目錄
define("THUMB_DIR", 'thumb/'); // 預覽圖存放目錄
define("PHP_SELF2", 'index.html'); // 入口檔名
define("PHP_EXT", '.html'); // 第一頁以後生成檔案之副檔名
define("TITLE", 'Pixmicat!-PIO'); // 網頁標題
define("HOME", '../'); // 回首頁的連結
define("TOP_LINKS", ''); // 頁面右上方的額外連結，請直接以[<a href="網址" rel="_blank">名稱</a>]格式鍵入，如果不需要開新視窗可刪除rel一段
define("ADMIN_PASS", 'futaba'); // 管理員密碼
define("IDSEED", 'id種'); // 生成ID之隨機種子

// 管理員キャップ(Cap)設定 (啟用條件：開啟使用；名稱輸入識別名稱，E-mail輸入#[啟動密碼])
define("CAP_ENABLE", 1); // 是否使用管理員キャップ (使用：1 不使用：0)
define("CAP_NAME", 'futaba'); // 管理員キャップ識別名稱
define("CAP_PASS", 'futaba'); // 管理員キャップ啟動密碼 (在E-mail一欄輸入#[啟動密碼])
define("CAP_SUFFIX", ' ★'); // 管理員キャップ後綴字元 (請務必有★以便程式防止偽造，或可自行修改程式的防偽造部份)
define("CAP_ISHTML", 1); // 管理員キャップ啟動後內文是否接受HTML標籤 (是：1 否：0)

// 功能切換
define("USE_THUMB", 1); // 使用預覽圖機能 (使用：1 不使用：0)
define("USE_FLOATFORM", 1); // 新增文章表單使用自動隱藏 (是：1 否：0)
define("USE_SEARCH", 1); // 開放搜尋功能 (是：1 否：0)
define("USE_UPSERIES", 1); // 是否啟用連貼機能 [開主題後自動指向到主題下以方便連貼] (是：1 否：0)
define("RESIMG", 1); // 回應附加檔案機能 (開啟：1 關閉：0)
define("AUTO_LINK", 1); // 討論串文字內的URL是否自動作成超連結 (是：1 否：0)
define("KILL_INCOMPLETE_UPLOAD", 1); // 自動刪除上傳不完整附加檔案 (是：1 否：0)
define("ALLOW_NONAME", 1); // 是否接受不輸入名稱即可正常貼文／回應 (是：1 否：0)
define("PROXY_CHECK", 0); // 限制Proxy寫入 (是：1 否：0)
define("DISP_ID", 2); // 顯示ID (強制顯示：2 選擇性顯示：1 永遠不顯示：0)
define("CLEAR_SAGE", 0); // 使用不推文模式時清除E-mail中的「sage」關鍵字 (是：1 否：0)
define("USE_QUOTESYSTEM", 1); // 是否打開引用瀏覽系統 (自動轉換>>No.xxx文字成連結並導引)

// 封鎖設定
define("DNSBL_CHECK", 0); // DNS-based Blackhole List(DNSBL) 黑名單功能 (關閉：0, 數字：使用伺服器數目)
$DNSBLservers = array('sbl-xbl.spamhaus.org', 'list.dsbl.org', 'bl.blbl.org', 'bl.spamcop.net'); // DNSBL伺服器列表，可自行增加
$DNSBLWHlist = array(''); // DNSBL白名單，排除被列為黑名單的項目 (為求簡便請以IP位置輸入而非主機位置名稱)
$BAD_STRING = array("dummy_string","dummy_string2"); // 限制出現之文字
$BAD_FILEMD5 = array("dummy","dummy2"); // 限制上傳附加檔案之MD5檢查碼
$BAD_IPADDR = array("addr.dummy.com","addr2.dummy.com"); // 限制之主機位置名稱

// 附加檔案限制
define("MAX_KB", 2000); // 附加檔案上傳容量限制KB (php內定為最高2MB)
define("STORAGE_LIMIT", 1); // 附加檔案容量限制功能 (啟動：1 關閉：0)
define("STORAGE_MAX", 30000); // 附加檔案容量限制上限大小 (單位：KB)
define("ALLOW_UPLOAD_EXT", 'GIF|JPG|PNG|BMP|SWF'); // 接受之附加檔案副檔名 (送出前表單檢查用，用 | 分隔)

// 連續投稿時間限制
define("RENZOKU", 10); // 連續投稿間隔秒數
define("RENZOKU2", 10); // 連續貼圖間隔秒數

// 預覽圖片相關限制
define("MAX_W", 250); // 討論串本文預覽圖片寬度 (超過則自動縮小)
define("MAX_H", 250); // 討論串本文預覽圖片高度
define("MAX_RW", 125); // 討論串回應預覽圖片寬度 (超過則自動縮小)
define("MAX_RH", 125); // 討論串回應預覽圖片高度
define("THUMB_Q", 75); // 預覽圖片之品質 (1-100, 建議預設75，越高品質越好但檔案也越大)

// 外觀設定
$ADDITION_INFO = ""; // 可在表單下顯示額外文字
define("USE_TEMPLATE", 0); // 是否使用樣板
define("TEMPLATE_FILE", 'inc_futaba.tpl'); // 樣板位置
define("PAGE_DEF", 15); // 一頁顯示幾篇討論串
define("ADMIN_PAGE_DEF", 20); // 管理模式下，一頁顯示幾筆資料
define("RE_DEF", 10); // 一篇討論串最多顯示之回應筆數 (超過則自動隱藏，全部隱藏：0)
define("RE_PAGE_DEF", 30); // 回應模式一頁顯示幾筆回應內容 (分頁用，全部顯示：0)
define("LOG_MAX", 500); // 記錄檔保留之最大資料筆數
define("MAX_RES", 30); // 回應筆數超過多少則不自動推文 (關閉：0)
define("MAX_AGE_TIME", 48); // 討論串可接受推文的時間範圍 (單位：小時，討論串存在超過此時間則回應皆不再自動推文 關閉：0)
define("RE_COL", '#789922'); // ＞標註引用回文顏色
define("COMM_MAX", 2000); // 內文接受Bytes數 (注意：中文字為2Bytes)
define("BR_CHECK", 0); // 文字換行行數上限 (不限：0)
define("STATIC_HTML_UNTIL", -1); // 更新文章時自動生成的靜態網頁至第幾頁止 (全部生成：-1 僅入口頁：0)
define("SHOW_IMGWH", 1); // 是否顯示附加檔案之原檔長寬尺寸 (是：1 否：0)
define("GZIP_COMPRESS_LEVEL", 3); // PHP動態輸出頁面使用Gzip壓縮層級 (關閉：0 啟動：1～9，推薦值：3)
?>