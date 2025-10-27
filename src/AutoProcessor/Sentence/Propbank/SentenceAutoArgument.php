<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\Propbank;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;

abstract class SentenceAutoArgument
{
    /**
     * The method should set all the semantic role labels in the sentence. The method assumes that the predicates
     * of the sentences were determined previously.
     * @param AnnotatedSentence $sentence The sentence for which semantic roles will be determined automatically.
     * @return bool True if the auto argument is successful.
     */
    abstract public function autoArgument(AnnotatedSentence $sentence): bool;
}