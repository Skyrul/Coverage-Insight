<?php
class WebUser extends CWebUser
{
    public $roles;
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param mixed $operation Name of the operation required (here, a role). Can be either string or an array of roles.
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params=array())
    {
        if (empty($this->id)) { // Not identified => no rights
            return false;
        }
        
        $role = $this->getState("roles"); // Get role of user
        if ($role === EnumRoles::ADMINISTRATOR) {
            return true; // admin role has access to everything
        }
        
        if(is_array($operation)) { // Check if multiple roles are available
            return (array_search($role,$operation)!==false);
        }
        
        return ($operation === $role);// allow access if the operation request is the current user's role
    }
    
}