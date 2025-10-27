<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\FrameNet;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;
use olcaytaner\AnnotatedSentence\AnnotatedWord;
use olcaytaner\Framenet\FrameNet;

class TurkishSentenceAutoFramePredicate extends SentenceAutoFramePredicate
{

    /**
     * Constructor for {@link TurkishSentenceAutoFramePredicate}. Gets the FrameSets as input from the user, and sets
     * the corresponding attribute.
     * @param FrameNet $frameNet FrameNet containing the Turkish frames.
     */
    public function __construct(FrameNet $frameNet){
        $this->frameNet = $frameNet;
    }

    /**
     * Checks all possible frame predicates and annotate them.
     * @param AnnotatedSentence $sentence The sentence for which frame predicates will be determined automatically.
     * @return bool True, if at least one frame predicate is annotated, false otherwise.
     */
    public function autoPredicate(AnnotatedSentence $sentence): bool
    {
        $candidateList = $sentence->predicateFrameCandidates($this->frameNet);
        foreach ($candidateList as $candidate){
            if ($candidate instanceof AnnotatedWord){
                $candidate->setFrameElementList("PREDICATE\$NONE$" . $candidate->getSemantic());
            }
        }
        if (count($candidateList) > 0){
            return true;
        }
        return false;
    }
}