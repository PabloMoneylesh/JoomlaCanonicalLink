<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );

class plgSystemArticlesCanonicalLink extends JPlugin {

	function plgSystemArticlesCanonicalLink (&$subject, $config) {
		parent::__construct($subject, $config);
	}

	/*This event is triggered before the framework creates the Head section of the Document.*/
	function onBeforeCompileHead () {
		
		$jApplicationCms = JFactory::getApplication();
		if (!$jApplicationCms->isSite()) {
			return;
		}

		$option   	= JRequest::getCmd('option');
		$view   	= JRequest::getCmd('view');
		$artId = JRequest::getVar('id');
		
		if ($option == "com_content" && $view == "article"){
			$cmodel = JModelLegacy::getInstance('Article', 'ContentModel');
			$catid = $cmodel->getItem($artId)->catid;
			$artRoute = ContentHelperRoute::getArticleRoute( $artId, $catid);		
			$canonicalLink = JRoute::_($artRoute);
			//var_dump( $canonicalLink);			
			$doc = JFactory::getDocument();
			$doc->addHeadLink(htmlspecialchars($canonicalLink), 'canonical');
		}
	}
}