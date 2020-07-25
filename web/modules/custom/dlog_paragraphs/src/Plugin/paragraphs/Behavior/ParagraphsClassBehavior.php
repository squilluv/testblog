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
 *  id = "dlog_paragraphs_paragraphs_class",
 *  label = @Translation("Paragraphs class settings"),
 *  description = @Translation("Settings for paragraph class"),
 *  weight = 0,
 * )
 */
class ParagraphsClassBehavior extends ParagraphsBehaviorBase
{
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return true;
    }

    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        $classes_value = $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', '');
        $classes = explode(' ', $classes_value);

        foreach ($classes as $class) {
            $build['#attributes']['class'][] = Html::getClass($class);
        }
    }

    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        $form['classes'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Classes'),
            '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'classes', ''),
        ];

        return $form;
    }
}
