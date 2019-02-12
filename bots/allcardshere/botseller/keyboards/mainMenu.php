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
                ->setActionBody('usecases')
                ->setText('Варианты использования'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('benefits')
                ->setText('Выгоды'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextSize('small')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('connectors')
                ->setText('Как это связать с нашими системами?'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#8074d6')
                ->setColumns(3)
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('effectually')
                ->setText('Когда есть смысл внедрять?'),
            (new \Viber\Api\Keyboard\Button())
                ->setBgColor('#2fa4e7')
                ->setTextSize('large')
                ->setTextHAlign('center')
                ->setActionType('reply')
                ->setActionBody('prices')
                ->setText('Сколько это может стоить?'),
        ]);