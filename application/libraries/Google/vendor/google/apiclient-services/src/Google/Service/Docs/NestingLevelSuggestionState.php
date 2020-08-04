<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Docs_NestingLevelSuggestionState extends Google_Model
{
  public $bulletAlignmentSuggested;
  public $glyphFormatSuggested;
  public $glyphSymbolSuggested;
  public $glyphTypeSuggested;
  public $indentFirstLineSuggested;
  public $indentStartSuggested;
  public $startNumberSuggested;
  protected $textStyleSuggestionStateType = 'Google_Service_Docs_TextStyleSuggestionState';
  protected $textStyleSuggestionStateDataType = '';

  public function setBulletAlignmentSuggested($bulletAlignmentSuggested)
  {
    $this->bulletAlignmentSuggested = $bulletAlignmentSuggested;
  }
  public function getBulletAlignmentSuggested()
  {
    return $this->bulletAlignmentSuggested;
  }
  public function setGlyphFormatSuggested($glyphFormatSuggested)
  {
    $this->glyphFormatSuggested = $glyphFormatSuggested;
  }
  public function getGlyphFormatSuggested()
  {
    return $this->glyphFormatSuggested;
  }
  public function setGlyphSymbolSuggested($glyphSymbolSuggested)
  {
    $this->glyphSymbolSuggested = $glyphSymbolSuggested;
  }
  public function getGlyphSymbolSuggested()
  {
    return $this->glyphSymbolSuggested;
  }
  public function setGlyphTypeSuggested($glyphTypeSuggested)
  {
    $this->glyphTypeSuggested = $glyphTypeSuggested;
  }
  public function getGlyphTypeSuggested()
  {
    return $this->glyphTypeSuggested;
  }
  public function setIndentFirstLineSuggested($indentFirstLineSuggested)
  {
    $this->indentFirstLineSuggested = $indentFirstLineSuggested;
  }
  public function getIndentFirstLineSuggested()
  {
    return $this->indentFirstLineSuggested;
  }
  public function setIndentStartSuggested($indentStartSuggested)
  {
    $this->indentStartSuggested = $indentStartSuggested;
  }
  public function getIndentStartSuggested()
  {
    return $this->indentStartSuggested;
  }
  public function setStartNumberSuggested($startNumberSuggested)
  {
    $this->startNumberSuggested = $startNumberSuggested;
  }
  public function getStartNumberSuggested()
  {
    return $this->startNumberSuggested;
  }
  /**
   * @param Google_Service_Docs_TextStyleSuggestionState
   */
  public function setTextStyleSuggestionState(Google_Service_Docs_TextStyleSuggestionState $textStyleSuggestionState)
  {
    $this->textStyleSuggestionState = $textStyleSuggestionState;
  }
  /**
   * @return Google_Service_Docs_TextStyleSuggestionState
   */
  public function getTextStyleSuggestionState()
  {
    return $this->textStyleSuggestionState;
  }
}
