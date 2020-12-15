<?php
/**
 * Třída pracující se session
 */
class SessionModel
{
    public function __construct()
    {
        session_start();
    }
    
    /**
     *  uloží hodnotu do session.
     *  @param string $name     jméno.
     *  @param mixed $value    hodnota
     */
    public function addSession($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    /**
     *  vrátí požadovanou hodnotu v session.
     *  @param string $name jméno atributu.
     *  @return mixed hodnotu a nebo NULL pokud není nastavena session
     */
    public function readSession($name)
    {
        if ($this->isSessionSet($name)) {
            return $_SESSION[$name];
        } else {
            return null;
        }
    }
    
    /**
     *  zjistí zda je v session nastaven
     *  @param string $name  jméno atributu.
     *  @return boolean true - je nastavena jinak false
     */
    public function isSessionSet($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     *  odstraní session
     *  @param string $name jméno atributu.
     */
    public function removeSession($name)
    {
        unset($_SESSION[$name]);
    }
}
