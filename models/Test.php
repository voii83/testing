<?php

class Test
{
    public static function getTestList()
    {
        $testList = [];
        $db = Db::getConnection();
        $result = $db->query('SELECT id, name FROM test');

        $i = 0;
        $result->setFetchMode(PDO::FETCH_ASSOC);
        while($row = $result->fetch()) {
            $testList[$i]['id'] = $row['id'];
            $testList[$i]['name'] = $row['name'];
            $i++;
        }

        return $testList;
    }

    public static function getTest($id)
    {
        if(!$id) return false;

        $db = Db::getConnection();
        $sql = 'SELECT questions.id as id_question, questions.question, answers.answer, answers.number_answer 
                FROM questions
                LEFT JOIN answers ON answers.id_question = questions.id
                WHERE id_test = :id';
        $result = $db->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $test = [];

        foreach ($result->fetchAll() as $item) {
            $test[$item['question']][] = [
                'answer' => $item['answer'],
                'number_answer' => $item['number_answer'],
                'id_question' => $item['id_question'],
            ];
        }

        return $test;
    }
}