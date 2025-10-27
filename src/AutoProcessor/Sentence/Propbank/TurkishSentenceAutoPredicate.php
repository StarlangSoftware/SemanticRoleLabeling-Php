<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\Propbank;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;
use olcaytaner\AnnotatedSentence\AnnotatedWord;
use olcaytaner\Propbank\FramesetList;
use olcaytaner\Propbank\Predicate;

class TurkishSentenceAutoPredicate extends SentenceAutoPredicate
{
    private FramesetList $framesetList;

    /**
     * Constructor for {@link TurkishSentenceAutoPredicate}. Gets the FrameSets as input from the user, and sets
     * the corresponding attribute.
     * @param FramesetList $framesetList FramesetList containing the Turkish propbank frames.
     */
    public function __construct(FramesetList $framesetList){
        $this->framesetList = $framesetList;
    }

    /**
     * The method uses predicateCandidates method to predict possible predicates. For each candidate, it sets for that
     * word PREDICATE tag.
     * @param AnnotatedSentence $sentence The sentence for which predicates will be determined automatically.
     * @return bool If at least one word has been tagged, true; false otherwise.
     */
    public function autoPredicate(AnnotatedSentence $sentence): bool
    {
        $candidateList = $sentence->predicateCandidates($this->framesetList);
        foreach ($candidateList as $candidate) {
            if ($candidate instanceof AnnotatedWord) {
                $candidate->setArgumentList("PREDICATE\$" . $candidate->getSemantic());
            }
        }
        if (count($candidateList) > 0) {
            return true;
        }
        return false;
    }
}