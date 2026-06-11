# Ejercicios de análisis de datos
# CAMPOS ELVIRA VALERIA 186831

from math import sqrt
from collections import Counter
import matplotlib.pyplot as plt
import numpy as np

# media
def calmedia(latency):
    cont = 0
    for i in latency:
        cont+=i
    return cont/n
  
#mediana
def calmediana(latency) :
    if (n%2 == 0):
        return (ordenad[(n//2)-1] + ordenad[n//2])/2
    else :
        return ordenad[n//2]

#moda
def moda(latency):
    for valor in latency:
        if valor in frecuencias:
            frecuencias[valor] +=1
        else: 
            frecuencias[valor] = 1

    max_freq = max(frecuencias.values())
    if (max_freq!=1):
        modas = []
        for valor, freq in frecuencias.items():
            if freq == max_freq:
                modas.append(valor)
        return modas
    else :
        return "No hay moda"

#varianza & desviación estandar
def des_var(latency):
  n    = len(latency)
  xmed = media
  cont=0

  for ii in range(n):
    sii = (latency[ii]-xmed)**2
    cont+=sii

  ss = cont/(n-1)
  s = sqrt(ss)

  return s,ss

#EJERCICIO 1 - LATENCIA DE UNA APLICACIÓN WEB
latency = [120,135,140,128,130,125,122,118,200,210,215,119,121,124,126]
frecuencias = {}
ordenad = sorted(latency)

n = len(latency)

media = calmedia(latency)
mediana = calmediana(latency) 
s,ss = des_var(latency)

print(f"\nPROBLEMA #1\n")
#1. RESUMEN ESTADISTICO
print(f"LA MEDIA ES: {media:.3f}")
print(f"LA MEDIANA ES: {mediana:.3f}")
print(f"LA(S) MODA(S) ES: {moda(latency)}")
print(f"La desviacion estandar s es: {s:.3f}")
print(f"La varianza s^2 es: {ss:.3f}")

#2. IDENTIFICAR SI HAY DATOS ATIPICOS 
time=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]
plt.plot(time,latency,"o")
plt.xlabel("Time (Days)")
plt.ylabel("Latency (ms)")

plt.show()
print(f"\nEn base al diagrama de puntos, si hay datos atipicos.Se observa que los datos 9,10,11 llegan a duplicar al resto de los valores.") 

#3. HISTOGRAMA
#gráfica de barras
plt.bar(time,latency)
plt.hlines(media,1,15,"r",ls="--",label="Media")
plt.hlines(mediana,1,15,"b",ls="--",label="Mediana")
plt.xlabel("Time (Days)")
plt.ylabel("Latency (ms)")
plt.legend()

plt.show()

#boxplot
plt.figure(figsize=(7, 5))
plt.boxplot(latency, patch_artist=True, tick_labels=["Latencia Total"], notch=True, flierprops={'marker': 'o', 'markerfacecolor': 'red', 'markersize': 8})

plt.axhline(media, color="r", ls="--", label="Media")
plt.axhline(mediana, color="b", ls="--", label="Mediana")
plt.xlabel("Variable de Análisis") 
plt.ylabel("Latency (ms)")
plt.legend()

plt.xlim(0.5, 1.5) 
plt.show()

#4. EXPLICA SI LA MEDIA REPRESENTA ADECUAAMENTE EL COMPORTAMIENTO TÍPICO
print(f"\nLa media NO representa el comportamiento típico, ya que la mayor cantidad datos se encuentran en rangos de 120 a 130, pero la presencia de datos atipicos (200,210,215) afecta la media de manera que tiene un valor más grande a lo esperado (142.2).") 

#EJERCICIO 2 - Uso diario de CPU en un servidor 
latency = [55, 60, 58, 62, 65, 70, 68, 72, 75, 80, 78, 76, 74, 73, 69, 66]
frecuencias = {}
ordenad = sorted(latency)

n = len(latency)

media = calmedia(latency)   
mediana = calmediana(latency)
s,ss = des_var(latency)

print(f"\nPROBLEMA #2\n")
#5. CALCULAR MEDIA,MEDIANA Y MODA 
print(f"LA MEDIA ES: {media:.3f}")
print(f"LA MEDIANA ES: {mediana:.3f}")
print(f"LA(S) MODA(S) ES: {moda(latency)}")

#6. CALCULAR VARIANZA Y DESVIACIÓN ESTANDAR
print(f"La desviacion estandar s es: {s:.3f}")
print(f"La varianza s^2 es: {ss:.3f}")

#7. DIAGRAMA DE PUNTOS E HISTOGRAMA
#fdiagrama de puntos
time=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16]
plt.plot(time,latency,"o")
plt.xlabel("Time (Horas)")
plt.ylabel("Latency (%CPU)")

plt.show() 

#gráfica de barras
plt.bar(time,latency)
plt.hlines(media,1,16,"r",ls="--",label="Media")
plt.hlines(mediana,1,16,"b",ls="--",label="Mediana")
plt.xlabel("Time (Horas)")
plt.ylabel("Latency (%CPU)")
plt.legend()

plt.show()

#8. INTERPRETA LA VARIABILIDAD DEL USO DE CPU
print(f"Es observable el como avanzan las horas el porcentaje de uso del CPU del servidor va aumentando hasta alcanzar un punto pico (valor máximo) de 80% en la hora 10 antes de empezar a disminuir nuevamente. Por lo que se supone que el CPU del servidor tiene un uso variable dependiendo de la hora.")

#EJERCICIO 3 - NÚMERO DE ERRORES POR DÍA
latency = [3, 5, 2, 4, 3, 6, 8, 7, 3, 2, 4, 5, 9, 10, 3]
frecuencias = {}
ordenad = sorted(latency)

n = len(latency)

media = calmedia(latency)   
mediana = calmediana(latency)
s,ss = des_var(latency)

print(f"\nPROBLEMA #3\n")
#9. RESUMEN ESTADISTICO
print(f"LA MEDIA ES: {media:.3f}")
print(f"LA MEDIANA ES: {mediana:.3f}")
print(f"LA(S) MODA(S) ES: {moda(latency)}")
print(f"La desviacion estandar s es: {s:.3f}")
print(f"La varianza s^2 es: {ss:.3f}")

#10. IDENTIFICA LA MODA Y EXPLICA SU SIGNIFICADO
print(f"\nLA(S) MODA(S) ES: {moda(latency)}")
print(f"La moda obtenida es de 3 errores por día, lo que indica que este fue el nivel de fallas más frecuente durante un periodo de 15 días. Es decir, el sistema normalmente opera con un número bajo de errores, representando un comportamiento más estable.")

#11. CONSTRUYE UN DIAGRAMA DE PUNTOS Y UN HISTOGRAMA
dias=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]

plt.plot(dias, latency, "o")
plt.xlabel("Días")
plt.ylabel("Errores")
plt.hlines(media, 1, 15,"r", ls="--", label="Media")
plt.hlines(mediana, 1, 15,"b", ls="--", label="Mediana")
plt.hlines(moda(latency), 1, 15,"y", ls="--", label="Moda")
plt.title("Errores por Día")
plt.legend()
plt.show()

valores = list(frecuencias.keys())
conteos = list(frecuencias.values())

# Graficar histograma de barras
plt.bar(valores, conteos)
plt.title("Histograma Frecuencia vs Errores")
plt.xlabel("Número de errores")
plt.ylabel("Frecuencia de errores")
plt.show()

#12. DESCRIBE EL COMPORTAMIENTO GENERAL DEL SISTEMA
print(f"\nEn general, el sistema presenta un comportamiento estable, ya que la mayoría de los días se registran entre 2 y 5 errores, siendo 3 errores por dia lo que más se repite. Sin embargo, existen datos atípicos como 8, 9 y 10 errores por día, los cuales se alejan del comportamiento normal. Estos valores elevan la media y aumentan la dispersión, pero pueden considerrse como fallas aisladas o situaciones extraordinarias. Por ello, se concluye que el sistema funciona de manera relativamente estable.")

#EJERCICIO 4 - TAMAÑO DE ARCHIVO DESCARGADOS
latency = [5, 7, 6, 8, 10, 12, 15, 7, 6, 9, 8, 50, 55, 60, 6]
frecuencias = {}
ordenad = sorted(latency)

usuarios = [0] * len(latency)
for i in range (len(latency)):
    usuarios[i] = i+1

n = len(latency)

media = calmedia(latency)   
mediana = calmediana(latency)
s,ss = des_var(latency)

print(f"\nPROBLEMA #4\n")
#13. RESUMEN ESTADISTICO
print(f"LA MEDIA ES: {media:.3f}")
print(f"LA MEDIANA ES: {mediana:.3f}")
print(f"LA(S) MODA(S) ES: {moda(latency)}")
print(f"La desviacion estandar s es: {s:.3f}")
print(f"La varianza s^2 es: {ss:.3f}")

#14. ANALIZA EL EFECTO DE LOS VALORES EXTREMOS
print(f"\nPRIMER VALOR: {ordenad[0],ordenad[1],ordenad[2],}")
print(f"ULTIMO VALOR: {ordenad[n-3],ordenad[n-2],ordenad[n-1]}")
print(f"La diferencia entre los primeros datos y los ultimos es muy grande, lo que va a causar que la tendencia general se desvie. Desplazando la media hacia la derecha Esto ocasiona que la mediana sea más representativa pues tiene una tendencia central.")

#15. HISTOGRAMA Y BLOXPOT
#histograma
plt.bar(usuarios, latency, color='#9d4edd', edgecolor='purple', alpha=0.7)
plt.title('Tamaño de archivos descargados por usuario', fontsize=14)
plt.xlabel('Número de Usuario', fontsize=12)
plt.ylabel('Tamaño (MB)', fontsize=12)
plt.xticks(usuarios)
plt.grid(True, alpha=0.3, axis='y')

for i in range(len(latency)):
    plt.text(usuarios[i], latency[i] + 0.5, str(latency[i]), ha='center', va='bottom', fontsize=9)

plt.show()

#boxplot
plt.boxplot(latency)
plt.title('Boxplot de los Datos', fontsize=14)
plt.xlabel('Usuarios', fontsize=12)
plt.ylabel('Tamaño (MB)', fontsize=12)
plt.grid(True, alpha=0.3, axis='y')

plt.show()

#16. COMPARA MEDIA Y MEDIANA COMO MEDIDA REPRESENTATIVA 
print("\nSe observan dos datos atípicos por los cuales los datos se ven sesgados, por lo tanto la media se ve afectada")
print("Es más representativa la mediana debido a que la media muestral se ve afectada por los valores atípicos")

#EJERCICIO 5 - TEMPERATURA DIARIA DE UNA CIUDAD
latency = [42,43,44,45,46,44,43,42,41,40,39,38,37,36]
frecuencias = {}
ordenad = sorted(latency)

n = len(latency)

media = calmedia(latency)
mediana = calmediana(latency) 
s,ss = des_var(latency)

print(f"\nPROBLEMA #5\n")
#17. RESUMEN ESTADISTICO
print(f"LA MEDIA ES: {media:.3f}")
print(f"LA MEDIANA ES: {mediana:.3f}")
print(f"LA(S) MODA(S) ES: {moda(latency)}")
print(f"La desviacion estandar es: {s:.3f}")
print(f"La varianza es: {ss:.3f}")

#18. CONSTRUIR UN HISTOGRAMA Y DIAGRAMA DE PUNTOS
#histograma
dias=[1,2,3,4,5,6,7,8,9,10,11,12,13,14]
plt.bar(dias, latency, color="#dd4eab")
plt.title('Temperatura de un servidor durante dos semanas:', fontsize=16)
plt.xlabel('Dias', fontsize=12)
plt.ylabel('Grados (°C)', fontsize=12)
plt.xticks(dias)
plt.grid(True, alpha=0.3, axis='y')

for i in range(len(latency)):
    plt.text(dias[i], latency[i] + 0.5, str(latency[i]), ha='center', va='bottom', fontsize=9)

plt.show()

#diagrama de puntos
plt.plot(dias,latency,"o")
plt.title('Diagrama de puntos de la temperatura de un servidor durante dos semanas:', fontsize=16)
plt.xlabel("Semana (Dias)")
plt.ylabel("Latency (°C)")

plt.show() 

#19. ANALIZA LA DISPERSIÓN DE LOS DATOS (DATOS ATIPICOS)
print(f"\nValor maximo: {ordenad[0],ordenad[1],ordenad[2],}")
print(f"Valor minimo: {ordenad[n-3],ordenad[n-2],ordenad[n-1]}")
print(f"Rango: {ordenad[n-1]-ordenad[0]:.2f}")
print(f"Al haber determinado tanto el valor maximo como minimo, se puede observar que ha habido un cambio notable en la temperatura en los últimos 14 dias debido al rango de 10°C.")

#20. EXPLICA SI EL SISTEMA OPERA DE MANERA ESTABLE
print(f"\nEl sistema no opera de manera estable, ya que se observa un aumento constante en la temperatura del servidor, alcanzando un pico de 46°C en el día 5, seguido de una disminución gradual. El servidor experimenta fluctuaciones significativas en su temperatura.")  