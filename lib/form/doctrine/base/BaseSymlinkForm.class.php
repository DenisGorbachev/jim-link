<?php

/**
 * Symlink form base class.
 *
 * @method Symlink getObject() Returns the current form's model object
 *
 * @package    jim-link
 * @subpackage form
 * @author     Anthony Regeda
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSymlinkForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'link_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Link'), 'add_empty' => true)),
      'key'        => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'link_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Link'), 'required' => false)),
      'key'        => new sfValidatorString(array('max_length' => 9)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('symlink[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Symlink';
  }

}
