using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarCTS : BDconexion
    {
        public List<EListarCTS> Listar_ListarCTS(String periodo)
        {
            List<EListarCTS> lCListarCTS = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarCTS oVListarCTS = new CListarCTS();
                    lCListarCTS = oVListarCTS.Listar_ListarCTS(con, periodo);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarCTS);
        }
    }
}