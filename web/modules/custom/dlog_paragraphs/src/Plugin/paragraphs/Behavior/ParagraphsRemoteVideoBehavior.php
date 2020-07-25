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
 *  id = "dlog_paragraphs_remote_video",
 *  label = @Translation("Paragraphs remote video settings"),
 *  description = @Translation("Settings for paragraph remote video"),
 *  weight = 0,
 * )
 */
class ParagraphsRemoteVideoBehavior extends ParagraphsBehaviorBase
{
    public static function isApplicable(ParagraphsType $paragraphs_type)
    {
        return $paragraphs_type->id() == "remote_video";
    }

    public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode)
    {
        $max_video_width = $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', '');
        $bem_block = 'paragraph-' . $paragraph->bundle() . ($view_mode == 'default' ? '' : '-' . $view_mode);

        $build['#attributes']['class'][] = Html::getClass($bem_block . '--video_width-' . $max_video_width);
    }

    public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state)
    {
        $form['video_width'] = [
            '#type' => 'select',
            '#title' => $this->t('Video width'),
            '#options' => [
                'full' => '100%',
                '720p' => '720p',
            ],
            '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'video_width', 'full'),
        ];

        return $form;
    }
}
