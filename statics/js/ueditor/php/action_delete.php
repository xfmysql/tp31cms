<?php
 
/*---------------------------
 * wang
 *zhibeiwang.blog.51cto.com
 * 2017-08-10
 * action_delete.php
 * 删除 Ueditor 目录下的文件
 *---------------------------*/
 
try {
    //获取路径 
    $path = $_POST['path'];
    $path = str_replace('../', '', $path);
    $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
    
    //安全判断(只允许删除 ueditor 目录下的文件) windows下是\uploads\
    if(stripos($path, '/uploads/') !== 0)
    {
        return '非法删除';
    }
    
    //获取完整路径
    $path = $_SERVER['DOCUMENT_ROOT'].$path;
    if(file_exists($path)) {
        //删除文件
        unlink($path);
        clearstatcache();
        return '文件删除成功';
    } else {
        return '删除失败，未找到'.$path;
    }
} catch (Exception $e) {
    return '删除异常：'.$e->getMessage();
}