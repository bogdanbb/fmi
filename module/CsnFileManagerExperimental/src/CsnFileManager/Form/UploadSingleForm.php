<?php
// File: UploadForm.php // File Post-Redirect-Get Plugin
namespace CsnFileManager\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

class UploadSingleForm extends Form
{

	protected $_dir;

    public function __construct($dir, $name = null, $options = array())
    {
        parent::__construct($name, $options);
		$this->_dir = $dir;
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Avatar Image Upload')
             ->setAttribute('id', 'image-file');
        $this->add($file);
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload',
                'id' => 'submitbutton',
            ),
        ));
    }

	/**
	 * Adding a RenameUpload filter to our form�s file input, with details on where the valid files should be stored
	 */
    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $fileInput = new InputFilter\FileInput('image-file');
        $fileInput->setRequired(true);
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => $this->_dir, // './data/tmpuploads/avatar.png',
                'randomize' => true, // false, // true,
            )
        );
        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }
}