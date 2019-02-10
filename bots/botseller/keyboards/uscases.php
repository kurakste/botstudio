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
                ->setActionBody('more-usecases')
                ->setText('Больше вариантов...'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('callback')
                ->setText('Заказать звонок'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#2fa4e7')
                ->setTextSize('large')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('menu')
                ->setText('Главное меню'),
        ]);