<?php
namespace Craft;

class GuestEntriesEmailPlugin extends BasePlugin
{
  //private $_customLinks;
  
  public function init()
	{
  	craft()->on('guestEntries.beforeSave', function(GuestEntriesEvent $event) {
    	// get entry object
      $entryModel = $event->params['entry'];
      $sectionId = $entryModel['attributes']['sectionId'];
      $section = craft()->sections->getSectionById($sectionId);
      $sectionHandle = $section['entryTypes'][0]['attributes']['handle'];
      
      // get settings
      $settings = $this->getSettings();
      $sendEmail = $settings['attributes']['sendEmail'][$sectionHandle];
      $emailSubject = $settings['attributes']['emailSubject'][$sectionHandle] . ': ' . $entryModel['title'];
      $emailAddresses = $settings['attributes']['emailAddresses'][$sectionHandle];
      
      if ($sendEmail === '1') {
        // setup sendto email addresses
        $sendToEmails = array_map('trim', explode(',', $emailAddresses));
        
        // assemble message
        $message = '<p><b>Title:</b> ' . $entryModel->title . '</p>';
        
        $entryAttributes = craft()->request->post['fields'];
        foreach ($entryAttributes as $key => $value) {
          if ($value != NULL) {
            $fieldTitle = craft()->fields->getFieldByHandle($key);
            
            if ($fieldTitle != NULL) {
              $message .= '<p><b>' . $fieldTitle . ':</b> ' . $value . '</p>';
            } else {
              $message .= '<p><b>' . $key . ':</b> ' . $value . '</p>';
            }
          }
        }
        
        // debug plugin
        /*
        print('<pre style="color: white; white-space: pre;">');
        var_dump($message);
        print('</pre>');
        $entryModel->addError('title', $message);
        $event->isValid = false;
        */
        
        // send email notification
        if ($event->isValid == true) {
          foreach ($sendToEmails as $value) {
            $email = new EmailModel();
            $email->toEmail = $value;
            $email->subject = $emailSubject;
            $email->body    = $message;
      
            craft()->email->sendEmail($email);
          }
        }
      }
    });
	}
  
  public function getName()
  {
    return Craft::t('Guest Entries Email Notification');
  }
  public function getVersion()
  {
    return '0.1.0';
  }
  public function getDeveloper()
  {
    return 'Will Browar';
  }
  public function getDeveloperUrl()
  {
    return 'http://wbrowar.com';
  }
  public function hasCpSection()
  {
    return false;
  }
  
  protected function defineSettings()
	{
		return array(
			'emailAddresses'  => AttributeType::Mixed,
			'emailSubject'    => AttributeType::Mixed,
			'sendEmail'       => AttributeType::Mixed,
		);
	}
	public function getSettingsHtml()
	{
  	$guestEntiresPlugin = craft()->plugins->getPlugin('guestentries', true);
  	if ($guestEntiresPlugin !== NULL) {
    	$guestEntiresPluginInstalled = true;
  	} else {
    	$guestEntiresPluginInstalled = false;
  	}
  	
  	
		$editableSections = array();
		$allSections = craft()->sections->getAllSections();
		
		foreach ($allSections as $section)
		{
			// No sense in doing this for singles.
			if ($section->type !== 'single')
			{
				$editableSections[$section->handle] = array('section' => $section);
			}
		}
		
		// output settings template
		return craft()->templates->render('guestentriesemail/settings', array(
			'settings' => $this->getSettings(),
			'editableSections' => $editableSections,
			'guestEntiresPluginInstalled' => $guestEntiresPluginInstalled,
		));
	}
}