<?php
class RegAction extends BaseAction {  
      
    public function index(){  
  
        if(!$this -> oauth -> verifyAccessToken()){  
            $this -> ajaxReturn(null, 'no,no,no', 0, 'json');  
        }  
        $this -> ajaxReturn(null, 'oauth-server', 1, 'json');  
          
    }  
      
}  