#!/bin/bash

# Executa o script Python
# cd /home/u457372996/indice-indicadores/
# python3 /home/u457372996/indice-indicadores/script.py
cd /var/www/indice/
pwd
python3 /var/www/indice/script.py

# Procura por arquivos CSV gerados pelo script Python
for arquivo in *.csv; do
    # Verifica se o arquivo é um arquivo CSV
    if [ -f "$arquivo" ]; then
        # Copia o arquivo CSV de resultado para a pasta especificada
        # cp "$arquivo" /home/u457372996/domains/legislabrasil.org/csv/
        cp "$arquivo" /var/www/csv/
        echo "Arquivo CSV '$arquivo' copiado com sucesso."
    else
        echo "Nenhum arquivo CSV gerado pelo script Python."
    fi
done