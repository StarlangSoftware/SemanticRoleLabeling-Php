<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\FrameNet;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;
use olcaytaner\Framenet\FrameNet;

abstract class SentenceAutoFramePredicate
{
    protected FrameNet $frameNet;

    /**
     * The method should set determine all frame predicates in the sentence.
     * @param AnnotatedSentence $sentence The sentence for which frame predicates will be determined automatically.
     * @return bool True if the auto frame predicate is successful.
     */
    abstract public function autoPredicate(AnnotatedSentence $sentence): bool;
}
