<?php
function gunzip ($in, $out)
{
    if (!file_exists ($in) || !is_readable ($in))
        return false;
    if ((!file_exists ($out) && !is_writable (dirname ($out)) || (file_exists($out) && !is_writable($out)) ))
        return false;

    $in_file = gzopen ($in, "rb");
    $out_file = fopen ($out, "wb");

    while (!gzeof ($in_file)) {
        $buffer = gzread ($in_file, 4096);
        fwrite ($out_file, $buffer, 4096);
    }
 
    gzclose ($in_file);
    fclose ($out_file);
   
    return true;
}
?>