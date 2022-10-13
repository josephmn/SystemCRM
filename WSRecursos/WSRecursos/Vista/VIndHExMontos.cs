using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VIndHExMontos : BDconexion
    {
        public List<EIndHExMontos> Listar_IndHExMontos()
        {
            List<EIndHExMontos> lCIndHExMontos = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CIndHExMontos oVIndHExMontos = new CIndHExMontos();
                    lCIndHExMontos = oVIndHExMontos.Listar_IndHExMontos(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCIndHExMontos);
        }
    }
}