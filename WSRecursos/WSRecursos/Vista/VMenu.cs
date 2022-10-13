using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMenu : BDconexion
    {
        public List<EMenu> Menu(Int32 dato)
        {
            List<EMenu> lCMenu = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMenu oVMenu = new CMenu();
                    lCMenu = oVMenu.Listar_Menu(con, dato);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCMenu);
        }
    }
}