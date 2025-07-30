<?php
namespace Config;
class MimTypes{
    public static function get(){
        return [
            // 🖼️ Images
            "avif" => "image/avif",
            "bmp" => "image/bmp",
            "gif" => "image/gif",
            "heic" => "image/heic",
            "ico" => "image/vnd.microsoft.icon",
            "jpeg" => "image/jpeg",
            "jpg" => "image/jpeg",
            "png" => "image/png",
            "svg" => "image/svg+xml",
            "webp" => "image/webp",
        
            // 🎥 Videos
            "3gp" => "video/3gpp",
            "avi" => "video/x-msvideo",
            "flv" => "video/x-flv",
            "m4v" => "video/x-m4v",
            "mkv" => "video/x-matroska",
            "mov" => "video/quicktime",
            "mp4" => "video/mp4",
            "webm" => "video/webm",
            "wmv" => "video/x-ms-wmv",
        
            // 🔊 Audio
            "flac" => "audio/flac",
            "m4a" => "audio/mp4",
            "mid" => "audio/midi",
            "midi" => "audio/midi",
            "mp3" => "audio/mpeg",
            "ogg" => "audio/ogg",
            "opus" => "audio/opus",
            "wav" => "audio/wav",
        
            // 🗜️ Archives / Compressed
            "7z" => "application/x-7z-compressed",
            "bz" => "application/x-bzip",
            "bz2" => "application/x-bzip2",
            "deb" => "application/x-debian-package",
            "dmg" => "application/x-apple-diskimage",
            "gz" => "application/gzip",
            "iso" => "application/x-iso9660-image",
            "rar" => "application/vnd.rar",
            "tar" => "application/x-tar",
            "xz" => "application/x-xz",
            "zip" => "application/zip",
        
            // 📄 Documents
            "csv" => "text/csv",
            "doc" => "application/msword",
            "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "epub" => "application/epub+zip",
            "odp" => "application/vnd.oasis.opendocument.presentation",
            "ods" => "application/vnd.oasis.opendocument.spreadsheet",
            "odt" => "application/vnd.oasis.opendocument.text",
            "pdf" => "application/pdf",
            "ppt" => "application/vnd.ms-powerpoint",
            "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
            "rtf" => "application/rtf",
            "tsv" => "text/tab-separated-values",
            "txt" => "text/plain",
            "xls" => "application/vnd.ms-excel",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        
            // 🗝️ Certificates / Keys
            "cer" => "application/pkix-cert",
            "crt" => "application/x-x509-ca-cert",
            "key" => "application/x-pem-key",
            "pem" => "application/x-pem-file",
            "p12" => "application/x-pkcs12",
            "pfx" => "application/x-pkcs12",
        
            // 🌐 Web
            "css" => "text/css",
            "html" => "text/html",
            "js" => "application/javascript",
            "json" => "application/json",
            "sitemap.xml" => "application/xml",
            "webmanifest" => "application/manifest+json",
            "xml" => "application/xml",
        
            // 🧑‍💻 Code
            "c" => "text/x-c",
            "go" => "text/x-go",
            "java" => "text/x-java-source",
            "md" => "text/markdown",
            "php" => "application/x-httpd-php",
            "py" => "text/x-python",
            "rb" => "text/x-ruby",
            "scss" => "text/x-scss",
            "sh" => "application/x-sh",
            "ts" => "application/typescript",
        
            // 🔤 Fonts
            "otf" => "font/otf",
            "ttf" => "font/ttf",
            "woff" => "font/woff",
            "woff2" => "font/woff2",
        
            // 📱 Apps / Packages
            "apk" => "application/vnd.android.package-archive",
            "exe" => "application/vnd.microsoft.portable-executable",
            "msi" => "application/x-msdownload",
        
            // 📚 eBooks
            "azw" => "application/vnd.amazon.ebook",
            "mob" => "application/x-mobipocket-ebook",
        
            // 🔧 Other
            "bin" => "application/octet-stream"
        ];
    }
}