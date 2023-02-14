public function chatmeaning(Request $request)
    {
        $grouper = $request->message;
        $message = "";
        $patternlist = "/[-]/";
        $splittext = preg_split($patternlist, $grouper);
        while (count($splittext) > 0) {

            $grouper = array_shift($splittext);
            $grouperdata = Grouper::where('Grouper', $grouper)->first();
            $groupermeaning = $grouperdata->Meaning ?? null;
            $message .= '' . $groupermeaning;
            $checktack1 = $grouperdata->Tack_1 ?? false;
            $checktack2 = $grouperdata->Tack_2 ?? false;
            $checktack3 = $grouperdata->Tack_3 ?? false;
            $checktack4 = $grouperdata->Tack_4 ?? false;
            $checkfreetexttack1 = $grouperdata->Free_Text_Tack_1 ?? false;
            $checkfreetexttack2 = $grouperdata->Free_Text_Tack_2 ?? false;
            $checkfreetexttack3 = $grouperdata->Free_Text_Tack_3 ?? false;
            $checkfreetexttack4 = $grouperdata->Free_Text_Tack_4 ?? false;
            $checkfreetexttack5 = $grouperdata->Free_Text_Tack_5 ?? false;
            $checkfreetexttack6 = $grouperdata->Free_Text_Tack_6 ?? false;
            $checklista = $grouperdata->List_A ?? false;
            $checklistb = $grouperdata->List_B ?? false;
            $checklistc = $grouperdata->List_C ?? false;
            $checkfreetextlist = $grouperdata->Free_Text_List ?? false;

            $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;

            if ($checkifnextitemisgrouper) {
            } else {

                $checkfortablegrouper = TableGrouper::select('Table_Grouper', 'Meaning')->where('Table_Grouper', $splittext[0] ?? null)->first() ? true : false;
                if ($checkfortablegrouper) {
                    $tablegrouper = array_shift($splittext);
                    $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
                    if (str_contains($message, 'Table_Group')) {
                        $message = str_replace('Table_Group', $tablegroupermeaning, $message);
                    } else {
                        $message .= " | " . $tablegroupermeaning;
                    }
                } else {
                    if ($checktack1) {
                        $tack = array_shift($splittext);
                        $splittack = explode(" ", $tack);
                        $tackmeaning = '';
                        while (count($splittack) > 0) {
                            $tackchar = array_shift($splittack);
                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? 'Tack_1';
                            $tackmeaning .= ' ' . $tackcharmeaning;
                        }
                        if (str_contains($message, 'Tack_1')) {
                            $message = str_replace('Tack_1', $tackmeaning, $message);
                        } else {
                            $message .= " | " . $tackmeaning;
                        }
                    }

                    if ($checkfreetexttack1) {
                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                        if ($checkifnextitemisgrouper) {
                        } else {
                            $freetexttack1 = array_shift($splittext) ?? 'Free_Text_Tack_1';
                            $freetexttack1 = str_replace('DSG', '', $freetexttack1);

                            if (str_contains($message, 'Free_Text_Tack_1')) {
                                $message = str_replace('Free_Text_Tack_1', $freetexttack1, $message);
                            } else {
                                $message .= " | " . $freetexttack1;
                            }

                            if ($checktack2) {
                                $tack = array_shift($splittext);
                                $splittack = explode(" ", $tack);
                                $tackmeaning = '';
                                while (count($splittack) > 0) {
                                    $tackchar = array_shift($splittack);
                                    $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? 'Tack_2';
                                    $tackmeaning .= ' ' . $tackcharmeaning;
                                }
                                if (str_contains($message, 'Tack_2')) {
                                    $message = str_replace('Tack_2', $tackmeaning, $message);
                                } else {
                                    $message .= " | " . $tackmeaning;
                                }
                            }

                            if ($checkfreetexttack2) {
                                $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                                if ($checkifnextitemisgrouper) {
                                } else {
                                    $freetexttack2 = array_shift($splittext) ?? 'Free_Text_Tack_2';
                                    $freetexttack2 = str_replace('DSG', '', $freetexttack2);
                                    if (str_contains($message, 'Free_Text_Tack_2')) {
                                        $message = str_replace('Free_Text_Tack_2', $freetexttack2, $message);
                                    } else {
                                        $message .= " | " . $freetexttack2;
                                    }

                                    if ($checktack3) {
                                        $tack = array_shift($splittext);
                                        $splittack = explode(" ", $tack);
                                        $tackmeaning = '';
                                        while (count($splittack) > 0) {
                                            $tackchar = array_shift($splittack);
                                            $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? 'Tack_3';
                                            $tackmeaning .= ' ' . $tackcharmeaning;
                                        }
                                        if (str_contains($message, 'Tack_3')) {
                                            $message = str_replace('Tack_3', $tackmeaning, $message);
                                        } else {
                                            $message .= " | " . $tackmeaning;
                                        }
                                    }

                                    if ($checkfreetexttack3) {
                                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                                        if ($checkifnextitemisgrouper) {
                                        } else {
                                            $freetexttack3 = array_shift($splittext) ?? 'Free_Text_Tack_3';
                                            $freetexttack3 = str_replace('DSG', '', $freetexttack3);
                                            if (str_contains($message, 'Free_Text_Tack_3')) {
                                                $message = str_replace('Free_Text_Tack_3', $freetexttack3, $message);
                                            } else {
                                                $message .= " | " . $freetexttack3;
                                            }

                                            if ($checktack4) {
                                                $tack = array_shift($splittext);
                                                $splittack = explode(" ", $tack);
                                                $tackmeaning = '';
                                                while (count($splittack) > 0) {
                                                    $tackchar = array_shift($splittack);
                                                    $tackcharmeaning = Tack::select('Meaning')->where('Grouper', $grouper)->where('Tack', $tackchar)->first()->Meaning ?? 'Tack_4';
                                                    $tackmeaning .= ' ' . $tackcharmeaning;
                                                }
                                                if (str_contains($message, 'Tack_4')) {
                                                    $message = str_replace('Tack_4', $tackmeaning, $message);
                                                } else {
                                                    $message .= " | " . $tackmeaning;
                                                }
                                            }
                                            if ($checkfreetexttack4) {
                                                $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                                                if ($checkifnextitemisgrouper) {
                                                } else {
                                                    $freetexttack4 = array_shift($splittext) ?? 'Free_Text_Tack_4';
                                                    $freetexttack4 = str_replace('DSG', '', $freetexttack4);
                                                    if (str_contains($message, 'Free_Text_Tack_4')) {
                                                        $message = str_replace('Free_Text_Tack_4', $freetexttack4, $message);
                                                    } else {
                                                        $message .= " | " . $freetexttack4;
                                                    }

                                                    if ($checkfreetexttack5) {
                                                        $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                                                        if ($checkifnextitemisgrouper) {
                                                        } else {
                                                            $freetexttack5 = array_shift($splittext) ?? 'Free_Text_Tack_5';
                                                            $freetexttack5 = str_replace('DSG', '', $freetexttack5);
                                                            if (str_contains($message, 'Free_Text_Tack_5')) {
                                                                $message = str_replace('Free_Text_Tack_5', $freetexttack5, $message);
                                                            } else {
                                                                $message .= " | " . $freetexttack5;
                                                            }


                                                            if ($checkfreetexttack6) {
                                                                $checkifnextitemisgrouper = Grouper::select('Meaning')->where('Grouper', $splittext[0] ?? null)->first() ? true : false;
                                                                if ($checkifnextitemisgrouper) {
                                                                } else {
                                                                    $freetexttack6 = array_shift($splittext) ?? 'Free_Text_Tack_6';
                                                                    $freetexttack6 = str_replace('DSG', '', $freetexttack6);
                                                                    if (str_contains($message, 'Free_Text_Tack_6')) {
                                                                        $message = str_replace('Free_Text_Tack_6', $freetexttack6, $message);
                                                                    } else {
                                                                        $message .= " | " . $freetexttack6;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if ($checklista) {
                        $ista = array_shift($splittext);
                        $istameaning = ListA::select('Meaning')->where('Grouper', $grouper)->where('List_A', $ista)->first()->Meaning ?? '(List A)';
                        if (str_contains($message, 'List_A')) {
                            $message = str_replace('List_A', $istameaning, $message);
                        } else {
                            $message .= " | " . $istameaning;
                        }
                    }
                    if ($checklistb) {
                        $listb = array_shift($splittext);
                        $splitcharlistb = str_split($listb);
                        $listbmeaning = '';
                        while (count($splitcharlistb) > 0) {
                            // return 'asdasd';
                            $listbchar = array_shift($splitcharlistb);
                            $listbcharmeaning = ListB::select('Meaning')->where('Grouper', $grouper)->where('List_B', $listbchar)->first()->Meaning ?? '(List B)';
                            $listbmeaning .= ' ' . $listbcharmeaning;
                        }

                        if (str_contains($message, 'List_B')) {
                            $message = str_replace('List_B', $listbmeaning, $message);
                        } else {
                            $message .= " | " . $listbmeaning;
                        }
                    }
                    if ($checklistc) {
                        $istc = array_shift($splittext);
                        $istcmeaning = ListC::select('Meaning')->where('Grouper', $grouper)->where('List_c', $istc)->first()->Meaning ?? '(List C)';


                        if (str_contains($message, 'List_C')) {
                            $message = str_replace('List_C', $istcmeaning, $message);
                        } else {
                            $message .= " | " . $istcmeaning;
                        }
                    }
                    if ($checkfreetextlist) {
                        $freetextlist = array_shift($splittext);

                        if (str_contains($message, 'Free_Text_List')) {
                            $message = str_replace('Free_Text_List', $freetextlist, $message);
                        } else {
                            $message .= " | " . $freetextlist;
                        }
                    }

                    $checkfortablegrouper = TableGrouper::select('Table_Grouper', 'Meaning')->where('Table_Grouper', $splittext[0] ?? null)->first()->Table_Grouper ?? null;
                    if ($checkfortablegrouper) {
                        $tablegrouper = array_shift($splittext);
                        $tablegroupermeaning = TableGrouper::select('Meaning')->where('Table_Grouper', $tablegrouper)->first()->Meaning ?? null;
                        if (str_contains($message, 'Table_Group')) {
                            $message = str_replace('Table_Group', $tablegroupermeaning, $message);
                        } else {
                            $message .= " | " . $tablegroupermeaning;
                        }
                    }
                }
            }


            $message .= "\n";
        }
        return response()->json(['message' => $message]);
        // return $message;
    }
