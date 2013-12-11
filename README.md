ushahidi_metaparams
===================

Add META tegs for each report (keywords and description)


To add view for admin panel:
 /var/www/application/controllers/reports.php
 line 442:
             $metaparams = array('id'=>$id, 'metakeywords'=>'','metadescription'=>'');
            Event::run('ushahidi_action.add_report_meta', $metaparams);
            $this->template->header->metadescription = $metaparams['metadescription'];
            $this->template->header->metakeywords = $metaparams['metakeywords'];


/var/www/application/controllers/main.php
line 111:
        //set metaparams
        $this->template->header->metakeywords = '';
        $this->template->header->metadescription = '';


