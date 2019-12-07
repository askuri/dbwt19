<?php
/**
 * error interpretieren
 */
namespace Emensa\Controller;

require './inc/PHPprepare.php';
require './models/Benutzer.php';
require './models/Gaeste.php';
require './models/FH_Angehoerige.php';
require './models/Studenten.php';
require './models/Fachbereiche.php';

class RegistrierenController {
    private $errormsgs = [];
    private $errorfields = [];
    
    public function run() {
        global $sql;
            
        $formvals = $_POST;
        $formvals['step'] = $formvals['step'] ?? 0;
        
        if ($formvals['step'] == 0) {
            $this->showView($formvals);
            
        } else if ($formvals['step'] == 1) {
            if ($formvals['pw1'] != $formvals['pw2']) {
                $this->addError('pw2', 'Die Passwörter stimmen nicht überein');
            }
            
            $this->showView($formvals);
            
        } else if ($formvals['step'] == 2) {
            $sql->begin_transaction();
            
            $benutzer = new \Emensa\Model\Benutzer();
            $benutzer->email = $formvals['email'];
            $benutzer->nutzername = $formvals['nickname'];
            $benutzer->hash = password_hash($formvals['pw1'], PASSWORD_BCRYPT);
            $benutzer->letzterlogin = empty($formvals['letzterlogin']) ? null : $formvals['letzterlogin'];
            $benutzer->vorname = $formvals['vorname'];
            $benutzer->nachname = $formvals['nachname'];
            $benutzer->geburtsdatum = empty($formvals['geburtsdatum']) ? null : $formvals['geburtsdatum'];
            $benutzer->add();
            
            foreach($benutzer->getSqlErrorList() as $error) {
                if (strpos($error['error'], 'Benutzer_Unique_email') !== false) {
                    $this->addError('email', 'Diese email Adresse kann nicht verwendet werden.');
                } else {
                    $this->addError('unkown', $error['error']);
                }
            }
            
            $nummer = $benutzer->nummer;
            
            if (!$this->hasErrors() && $formvals['gast']) {
                $gast = new \Emensa\Model\Geaste();
                $gast->nummer = $nummer;
                $gast->grund = $formvals['grund'];
                $gast->ablaufdatum = $formvals['ablaufdatum'];
                $gast->add();
                
            } else if (!$this->hasErrors() && ($formvals['mitarbeiter'] || $formvals['student'])) {
                $fh_ang = new \Emensa\Model\FH_Angehoerige();
                $fh_ang->nummer = $nummer;
                $fh_ang->fachebereichIDs = $formvals['fachbereiche'] ?? [];
                $fh_ang->add();
                
                if ($fh_ang->getSqlError()) {
                    $this->addError('unkown', $fh_ang->getSqlError());
                }
                
                if (!$this->hasErrors() && $formvals['mitarbeiter']) {
                    /*
                    $mitarbeiter = new \Emensa\Model\Mitarbeiter();
                    $mitarbeiter->nummer = $nummer;
                    $mitarbeiter->buero = empty($formvals['buero']) ? null : $formvals['buero'];
                    $mitarbeiter->telefon = empty($formvals['telefon']) ? null : $formvals['telefon'];
                    */
                    $this->addError('nix', 'Aktuell nicht möglich sich als Mitarbeiter zu registrieren.');
                } else if (!$this->hasErrors()) {
                    $student = new \Emensa\Model\Studenten();
                    $student->nummer = $nummer;
                    $student->studiengang = $formvals['studiengang'];
                    $student->matrikelnummer = $formvals['matrikelnummer'];
                    $student->add();
                    
                    foreach ($student->getSqlErrorList() as $error) {
                        if (strpos($error['error'], 'Studenten_unique_Matrikelnummer') !== false) {
                            $this->addError('matrikelnummer', 'Diese Matrikelnummer ist bereits vergeben.');
                            
                        } elseif (strpos($error['error'], 'Studenten_check_Matrikelnummer') !== false
                                || strpos($error['error'], 'Out of range') !== false) {
                            $this->addError('matrikelnummer', 'Diese Matrikelnummer ist ungültig.');
                            
                        } else {
                            $this->addError('unkown', $error['error']);
                        }
                    }
                }
            }
            
            $this->showView($formvals);
        } else {
            $this->showView($formvals);
        }
    }

    public function showView($formvals){
        global $blade, $sql;
        
        // only go to the next step if no errors occured
        if ($this->hasErrors()) {
            $sql->rollback();
        } else {
            $sql->commit();
            $formvals['step']++;
        }
        
        // get extra data for views
        $fachbereiche = (new \Emensa\Model\Fachbereiche())->getAll();
        $studiengaenge = (new \Emensa\Model\Studenten())->getStudiengaenge();
        
        echo $blade->run("registrieren.index", [
            'formvals' => $formvals,
            'errormsgs' => $this->errormsgs,
            'errorfields' => $this->errorfields,
            'fachbereiche' => $fachbereiche,
            'studiengaenge' => $studiengaenge,
        ]);
    }
    
    private function addError($field, $message) {
        $this->errorfields[] = $field;
        $this->errormsgs[] = $message;
    }
    
    private function hasErrors() {
        return !empty($this->errorfields);
    }
}
?>
