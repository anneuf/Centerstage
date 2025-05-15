import tkinter as tk
import tkinter.font
from tkinter import filedialog as fd
import time
import sys
import os
import sqlite3

def startCs():
    startString = sys.executable + ' cs.py'
    os.system(startString)

def loadDB():
    filetypes = [('Sqlite 3 DB', '*.sqlite3')]
    filename = fd.askopenfilename(title='Select Database', filetypes=filetypes)
    match os.name:
        case 'posix':
            execCommand = 'cp ' + filename + ' ' + os.path.abspath(os.getcwd()) + '/Centerstage.sqlite3'
            os.system(execCommand)
        case 'nt':
            execCommand = 'copy ' + filename.replace('/', '\\') + ' ' + os.path.abspath(os.getcwd()) + '\\Centerstage.sqlite3'
            os.system(execCommand)


def editShow():
    startString = sys.executable + ' selectshow.py 1'
    os.system(startString)

def selectShow():
    startString = sys.executable + ' selectshow.py 2'
    os.system(startString)

def editSong():
    pass

def exitMenu():
    main.destroy()

def showActShow():
    con = sqlite3.connect('Centerstage.sqlite3')
    cur = con.cursor()
    for row in cur.execute('SELECT * FROM current_show'):
        curShow = row[0]
    for row in cur.execute('SELECT * FROM show WHERE idshow=' + str(curShow)):
        showLabel2.config(text = row[1])
    con.close()
    main.after(5000, showActShow)

main = tk.Tk()
main.title("Centerstage Main")
main.config(bg="#aaaaaa")
# main.geometry("800x600+200+200")
main.resizable(False, False)

TitleFont = tk.font.Font(family='Helvetica', size=21, weight='bold')
ButtonFont = tk.font.Font(family='Helvetica', size=15, weight='bold')

Title = tk.Label(main, text='Centerstage Main Menu', fg='#ffff00', bg='#aaaaaa', font=TitleFont, padx=10, pady=10)
Title.grid(row=0, column=0, sticky='ew')
blankLabel1 = tk.Label(main, text='', bg='#aaaaaa')
blankLabel1.grid(row=1, column=0, sticky='ew')
showLabel1 = tk.Label(main, text='Current Show:', fg='#00ff00', bg='#aaaaaa', font=ButtonFont)
showLabel1.grid(row=2, column=0, sticky='ew')
showLabel2 = tk.Label(main, text='', fg='#ff0000', bg='#aaaaaa', font=ButtonFont)
showLabel2.grid(row=3, column=0, sticky='ew')
blankLabel2 = tk.Label(main, text='', bg='#aaaaaa')
blankLabel2.grid(row=4, column=0, sticky='ew')
button1 = tk.Button(main, text='Start Centerstage', command=startCs, font=ButtonFont)
button1.grid(row=5, column=0, sticky='ew')
button2 = tk.Button(main, text='Load Database', command=loadDB, font=ButtonFont)
button2.grid(row=6, column=0, sticky='ew')
button3 = tk.Button(main, text='Select Show', command=selectShow, font=ButtonFont)
button3.grid(row=7, column=0, sticky='ew')
button4 = tk.Button(main, text='Edit Shows', command=editShow, font=ButtonFont)
button4.grid(row=8, column=0, sticky='ew')
button5 = tk.Button(main, text='Edit Songs', command=editSong, font=ButtonFont)
button5.grid(row=9, column=0, sticky='ew')
blankLabel4 = tk.Label(main, text='', bg='#aaaaaa')
blankLabel4.grid(row=10, column=0, sticky='ew')
button6 = tk.Button(main, text='Exit', command=exitMenu, font=ButtonFont)
button6.grid(row=11, column=0, sticky='ew')

showActShow()

main.mainloop()
