using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarCalendario : BDconexion
    {
        public List<EListarCalendario> Listar_ListarCalendario()
        {
            List<EListarCalendario> lCListarCalendario = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarCalendario oVListarCalendario = new CListarCalendario();
                    lCListarCalendario = oVListarCalendario.Listar_ListarCalendario(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarCalendario);
        }
    }
}