#!/bin/bash

# Verifica se o processo está em execução
if ps aux | grep -v grep | grep "indice-cron.sh" > /dev/null
then
    echo "O processo indice-cron.sh está em execução."
else
    # Verifica se existe um arquivo na pasta com o nome contendo a data do dia e a extensão .csv
    data=$(date +'%Y-%m-%d')
    arquivo="indicador-default-$data.csv"
    pasta="/var/www/csv/"  # Substitua pelo caminho correto da sua pasta

    if [ -f "$pasta/$arquivo" ]
    then
        echo "O arquivo $arquivo existe na pasta."
    else
        echo "O arquivo $arquivo não existe na pasta. Iniciando o processo indice-cron.sh..."
        # Inicia o processo indice-cron.sh
        /var/www/html/indice-cron.sh &  # Substitua pelo caminho correto do seu script
    fi
fi