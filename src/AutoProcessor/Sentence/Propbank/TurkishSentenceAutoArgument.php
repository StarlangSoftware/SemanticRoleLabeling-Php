<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\Sentence\Propbank;

use olcaytaner\AnnotatedSentence\AnnotatedSentence;
use olcaytaner\AnnotatedSentence\AnnotatedWord;
use olcaytaner\MorphologicalAnalysis\MorphologicalAnalysis\MorphologicalTag;

class TurkishSentenceAutoArgument extends SentenceAutoArgument
{

    /**
     * Given the sentence for which the predicate(s) were determined before, this method automatically assigns
     * semantic role labels to some/all words in the sentence. The method first finds the first predicate, then assuming
     * that the shallow parse tags were preassigned, assigns ÖZNE tagged words ARG0; NESNE tagged words ARG1. If the
     * verb is in passive form, ÖZNE tagged words are assigned as ARG1.
     * @param AnnotatedSentence $sentence The sentence for which semantic roles will be determined automatically.
     * @return bool If the method assigned at least one word a semantic role label, the method returns true; false otherwise.
     */
    public function autoArgument(AnnotatedSentence $sentence): bool
    {
        $modified = false;
        $predicateId = null;
        for ($i = 0; $i < $sentence->wordCount(); $i++) {
            $word = $sentence->getWord($i);
            if ($word instanceof AnnotatedWord && $word->getArgumentList() != null && $word->getArgumentList()->containsPredicate()) {
                $predicateId = $word->getSemantic();
                break;
            }
        }
        if ($predicateId !== null) {
            for ($i = 0; $i < $sentence->wordCount(); $i++) {
                $word = $sentence->getWord($i);
                if ($word instanceof AnnotatedWord && $word->getArgumentList() == null) {
                    if ($word->getShallowParse() == "ÖZNE") {
                        if ($word->getParse() != null && $word->getParse()->containsTag(MorphologicalTag::PASSIVE)){
                            $word->setArgumentList("ARG1\$" . $predicateId);
                        } else {
                            $word->setArgumentList("ARG0\$" . $predicateId);
                        }
                        $modified = true;
                    } else {
                        if ($word->getShallowParse() == "NESNE"){
                            $word->setArgumentList("ARG1\$" . $predicateId);
                            $modified = true;
                        }
                    }
                }
            }
        }
        return $modified;
    }
}