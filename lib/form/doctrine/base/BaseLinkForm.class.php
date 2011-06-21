<?php

/**
 * Link form base class.
 *
 * @method Link getObject() Returns the current form's model object
 *
 * @package    jim-link
 * @subpackage form
 * @author     Anthony Regeda
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLinkForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'hash'       => new sfWidgetFormInputText(),
      'url'        => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'hash'       => new sfValidatorString(array('max_length' => 32)),
      'url'        => new sfValidatorString(array('max_length' => 1024)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Link', 'column' => array('hash')))
    );

    $this->widgetSchema->setNameFormat('link[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Link';
  }

}
