<?php
class Model_Login extends Model
{	      
    //Проверям, существует ли пользователь
    function getUser(string $User_login, string $Password, string $Hash, string $Ip, string $Insip='', string $VKpass=null)
	{
        // проверяем, не существует ли пользователя с таким именем
        $sql = "select user_id, user_password from sfimggallery.users where user_login = '$User_login' LIMIT 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->FETCH(PDO::FETCH_ASSOC);
        if (is_null($VKpass) & ($result['user_password']===md5(md5($_POST['password']))))
        {
            // Записываем в БД новый хеш авторизации и IP
            $sql = "update sfimggallery.users set user_hash='".$Hash.$Insip."' where user_id='".$result['user_id']."';";          
            $createResult=$this->db->prepare($sql); 
            $createResult->execute();
            if($createResult->rowCount()>0)
            {
                return $result['user_id'];
            }  
            return null;
        } 
        elseif(!is_null($VKpass))
        {
            // Записываем в БД новый хеш авторизации и IP
            $sql = "update sfimggallery.users set user_hash='".$Hash.$Insip."' where user_id='".$result['user_id']."';";          
            $createResult=$this->db->prepare($sql); 
            $createResult->execute();
            if($createResult->rowCount()>0)
            {
                return $result['user_id'];
            }  
            return null;            
        }
        else 
        {
            return null;
        }              
    }
    //Интеграция в VK
    //Создаём пользователя
    function createUser(string $User_login, string $UserPassword, int $RoleID=2)
    {
        // Убираем лишние пробелы и делаем двойное хэширование (используем старый метод md5)
        $password = md5(md5(trim($UserPassword)));         
        $sql = "insert into sfimggallery.users(user_login, user_password) 
        values ('".$User_login."', '".$password."');";   
        $result =  $this->db->exec($sql); 
        if($result)
        {
            $sql = "select user_id from sfimggallery.users  where user_login = '$User_login'LIMIT 1";
            $stmt = $this->db->query($sql);
            $result = $stmt->FETCH(PDO::FETCH_ASSOC);
            $user_id = $result['user_id'];
            //добавляем роль пользователю по умолчанию
            $sql = "insert into sfimggallery.rolesmap(role_id, user_id) 
            values ('".$RoleID."', '".$user_id."');";                          
            $result =  $this->db->exec($sql);
            return true;
        }  
        return false; 
    }
}?>