<?php
ini_set("display_errors","on");
class CacheManager  
{  
     public function get($key)  
     {  
          return apc_fetch($key);  
     }  

     public function store($key, $data, $ttl)  
     {  
          return apc_store($key, $data, $ttl);  
     }  

     public function delete($key)  
     {  
          return apc_delete($key);  
     }  
}
?>