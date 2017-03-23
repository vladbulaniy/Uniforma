<?php
/**
 * jSecure components for Joomla!
 * jSecure is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2011
 * @package     jSecure
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: admin.jsplocation.php  $
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class com_jsecureInstallerScript
{
        function install($parent)
        {          
            $manifest = $parent->get("manifest");
            $parent = $parent->getParent();
            $source = $parent->getPath("source");
             
            $installer = new JInstaller();
            
            foreach($manifest->plugins->plugin as $plugin) {
                $attributes = $plugin->attributes();
                $plg = $source . '/' . $attributes['folder'].'/'.$attributes['plugin'];
                $installer->install($plg);
            }
            
            
            $db = JFactory::getDbo();
            $tableExtensions = $db->nameQuote("#__extensions");
            $columnElement   = $db->nameQuote("element");
            $columnType      = $db->nameQuote("type");
            $columnEnabled   = $db->nameQuote("enabled");

            $db->setQuery('update #__extensions set enabled = 1 where element = "jsecure" and type = "plugin"');
            $db->query();
			
            
        }


		function uninstall($parent) 
	{
		$database	= & JFactory::getDBO();
         jimport('joomla.filesystem.file');

      // remove system plugin
	$database->setQuery( "DELETE FROM `#__extensions` WHERE `element`= 'jsecure';");
	$database->query();

	JFile::delete( JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure.php' );
	JFile::delete( JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure.xml' );
	JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'404.html'); 

	JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure'.'/'.'jsecure.class.php');
	JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure'.'/'.'css'.'/'.'jsecure.css');
	JFile::delete(JPATH_ROOT.'/'.'administrator'.'/'.'language'.'/'.'en-GB'.'/'.'en-GB.plg_system_jsecure.ini');
	
	rmdir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure'.'/'.'css');
	rmdir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure'.'/'.'jsecure');
	rmdir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsecure');

	echo '<h3>jSecure has been succesfully uninstalled.</h3>';
	}

     
}