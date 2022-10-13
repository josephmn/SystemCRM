using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VOcupacion : BDconexion
    {
        public List<EOcupacion> Ocupacion()
        {
            List<EOcupacion> lCOcupacion = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    COcupacion oVOcupacion = new COcupacion();
                    lCOcupacion = oVOcupacion.Listar_Ocupacion(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCOcupacion);
        }
    }
}