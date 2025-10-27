<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\Propbank;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;

abstract class SentenceAutoPredicate
{
    /**
     * The method should set determine all predicates in the sentence.
     * @param AnnotatedSentence $sentence The sentence for which predicates will be determined automatically.
     * @return bool True if the auto predicate is successful.
     */
    public abstract function autoPredicate(AnnotatedSentence $sentence): bool;
}