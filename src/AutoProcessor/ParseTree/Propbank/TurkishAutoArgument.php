<?php

namespace olcaytaner\SemanticRoleLabeling\AutoProcessor\ParseTree\Propbank;

use olcaytaner\AnnotatedSentence\ViewLayerType;
use olcaytaner\AnnotatedTree\ParseNodeDrawable;
use olcaytaner\ParseTree\ParseNode;
use olcaytaner\Propbank\ArgumentType;

class TurkishAutoArgument extends AutoArgument
{

    /**
     * Sets the language.
     */
    public function __construct(){
        parent::__construct(ViewLayerType::TURKISH_WORD);
    }

    /**
     * Checks all ancestors of the current parse node, until an ancestor has a tag of given name, or the ancestor is
     * null. Returns the ancestor with the given tag, or null.
     * @param ParseNode $parseNode Parse node to start checking ancestors.
     * @param string $name Tag to check.
     * @return bool The ancestor of the given parse node with the given tag, if such ancestor does not exist, returns null.
     */
    private function checkAncestors(ParseNode $parseNode, string $name): bool{
        while ($parseNode != null){
            if ($parseNode->getData()->getName() == $name){
                return true;
            }
            $parseNode = $parseNode->getParent();
        }
        return false;
    }

    /**
     * Checks all ancestors of the current parse node, until an ancestor has a tag with the given, or the ancestor is
     * null. Returns the ancestor with the tag having the given suffix, or null.
     * @param ParseNode $parseNode Parse node to start checking ancestors.
     * @param string $suffix Suffix of the tag to check.
     * @return bool The ancestor of the given parse node with the tag having the given suffix, if such ancestor does not
     * exist, returns null.
     */
    private function checkAncestorsUntil(ParseNode $parseNode, string $suffix): bool{
        while ($parseNode != null){
            if (str_contains($parseNode->getData()->getName(), "-" . $suffix)){
                return true;
            }
            $parseNode = $parseNode->getParent();
        }
        return false;
    }

    /**
     * The method tries to set the argument of the given parse node to the given argument type automatically. If the
     * argument type condition matches the parse node, it returns true, otherwise it returns false.
     * @param ParseNodeDrawable $parsenode
     * @param ArgumentType $argumentType Semantic role to check.
     * @return bool True, if the argument type condition matches the parse node, false otherwise.
     */
    protected function autoDetectArgument(ParseNodeDrawable $parsenode, ArgumentType $argumentType): bool
    {
        $parent = $parsenode->getParent();
        switch ($argumentType){
            case ArgumentType::ARG0:
                if ($this->checkAncestorsUntil($parent, "SBJ")){
                    return true;
                }
                break;
            case ArgumentType::ARG1:
                if ($this->checkAncestorsUntil($parent, "OBJ")){
                    return true;
                }
                break;
            case ArgumentType::ARGMADV:
                if ($this->checkAncestorsUntil($parent, "ADV")){
                    return true;
                }
                break;
            case ArgumentType::ARGMTMP:
                if ($this->checkAncestorsUntil($parent, "TMP")){
                    return true;
                }
                break;
            case ArgumentType::ARGMMNR:
                if ($this->checkAncestorsUntil($parent, "MNR")){
                    return true;
                }
                break;
            case ArgumentType::ARGMLOC:
                if ($this->checkAncestorsUntil($parent, "LOC")){
                    return true;
                }
                break;
            case ArgumentType::ARGMDIR:
                if ($this->checkAncestorsUntil($parent, "DIR")){
                    return true;
                }
                break;
            case ArgumentType::ARGMDIS:
                if ($this->checkAncestorsUntil($parent, "CC")){
                    return true;
                }
                break;
            case ArgumentType::ARGMEXT:
                if ($this->checkAncestorsUntil($parent, "EXT")){
                    return true;
                }
                break;
        }
        return false;
    }
}