<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\ParseTree\Propbank;

use olcaytaner\AnnotatedSentence\ViewLayerType;
use olcaytaner\AnnotatedTree\ParseNodeDrawable;
use olcaytaner\AnnotatedTree\ParseTreeDrawable;
use olcaytaner\AnnotatedTree\Processor\Condition\IsTransferable;
use olcaytaner\AnnotatedTree\Processor\NodeDrawableCollector;
use olcaytaner\Dictionary\Dictionary\Word;
use olcaytaner\Propbank\ArgumentType;
use olcaytaner\Propbank\ArgumentTypeStatic;
use olcaytaner\Propbank\Frameset;

abstract class AutoArgument
{
    protected ViewLayerType $secondLanguage;
    protected abstract function autoDetectArgument(ParseNodeDrawable $parsenode, ArgumentType $argumentType): bool;

    public function __construct(ViewLayerType $secondLanguage){
        $this->secondLanguage = $secondLanguage;
    }

    /**
     * Given the parse tree and the frame net, the method collects all leaf nodes and tries to set a propbank argument
     * label to them. Specifically it tries all possible argument types one by one ARG0 first, then ARG1, then ARG2 etc.
     * Each argument type has a special function to accept. The special function checks basically if there is a specific
     * type of ancestor (specific to the argument, for example SUBJ for ARG0), or not.
     * @param ParseTreeDrawable $parseTree Parse tree for semantic role labeling
     * @param Frameset $frameset Frame net used in labeling.
     */
    public function autoArgument(ParseTreeDrawable $parseTree, Frameset $frameset): void{
        $nodeDrawableCollector = new NodeDrawableCollector($parseTree->getRoot(), new IsTransferable($this->secondLanguage));
        $leafList = $nodeDrawableCollector->collect();
        foreach ($leafList as $leaf) {
            if ($leaf instanceof ParseNodeDrawable && $leaf->getLayerData(ViewLayerType::PROPBANK) == null){
                foreach (ArgumentType::cases() as $argumentType) {
                    if ($frameset->containsArgument(ArgumentTypeStatic::getArguments($argumentType->name)) &&
                    $this->autoDetectArgument($leaf, ArgumentTypeStatic::getArguments($argumentType->name))) {
                        $leaf->getLayerInfo()->setLayerData(ViewLayerType::PROPBANK, $argumentType->name);
                    }
                }
                if (Word::isPunctuationSymbol($leaf->getLayerData($this->secondLanguage))){
                    $leaf->getLayerInfo()->setLayerData(ViewLayerType::PROPBANK, "NONE");
                }
            }
        }
    }
}