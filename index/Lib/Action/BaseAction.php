<?php
import("ORG.OAuth.ThinkOAuth2");    
class BaseAction extends Action {  
      
    protected $oauth = NULL;  
  
    function _initialize(){  
          
        $this -> oauth = new ThinkOAuth2();  
  
    }  
      
    public function index(){  
          
        if(!$this -> oauth -> verifyAccessToken()){  
            $this -> ajaxReturn(null, 'no,no,no', 0, 'json');  
            exit();  
        }  
        $this -> ajaxReturn(null, 'oauth-server', 1, 'json');  
          
    }  
      
}  