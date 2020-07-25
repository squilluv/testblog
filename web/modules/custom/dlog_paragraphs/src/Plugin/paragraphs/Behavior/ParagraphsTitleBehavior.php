<?php

namespace Drupal\dlog_paragraphs\Plugin\paragraphs\Behavior;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * @ParagraphsBehavior(
 *  id = "dlog_paragraphs_paragraphs_title",
 *  label = @Translation("Paragraphs title settings"),
 *  description = @Translation("Settings for paragraph title"),
 *  weight = 0,
 * )
 */
class ParagraphsTitleBehavior extends ParagraphsBehaviorBase
{
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return true;
    }

    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
    }

    public function preprocess(&$variables){
        $paragraph = $variables['paragraph'];
        $variables['title_wrapper'] = $paragraph->getBehaviorSetting($this->getPluginId(), 'title_wrapper', 'h2');

    }

    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        if($paragraph->hasField('field_title')){
            $default = 'h2';

            $form['title_wrapper'] = [
                '#type' => 'select',
                '#title' => $this->t('Title wrapper element'),
                '#options' => $this->getHeadingOptions(),
                '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'title_wrapper', 'h2'),
            ];
        }

        return $form;
    }

    public function getHeadingOptions(){
        return [
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'div' => 'div',
        ];
    }
}
