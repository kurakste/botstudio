<?php
return  
    (new \Viber\Api\Keyboard())
        ->setButtons([
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextSize('small')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('cardlist')
                ->setText('Список карт.'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextSize('small')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('donate')
                ->setText('Сказать спасибо'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#2fa4e7')
                ->setTextSize('large')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('menu')
                ->setText('СПРАВКА'),
        ]);