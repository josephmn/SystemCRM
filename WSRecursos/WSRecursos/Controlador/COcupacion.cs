using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class COcupacion
    {
        public List<EOcupacion> Listar_Ocupacion(SqlConnection con)
        {
            List<EOcupacion> lEOcupacion = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_OCUPACION", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEOcupacion = new List<EOcupacion>();

                EOcupacion obEOcupacion = null;
                while (drd.Read())
                {
                    obEOcupacion = new EOcupacion();
                    obEOcupacion.i_id = drd["i_id"].ToString();
                    obEOcupacion.v_descripcion = drd["v_descripcion"].ToString();
                    obEOcupacion.v_default = drd["v_default"].ToString();
                    lEOcupacion.Add(obEOcupacion);
                }
                drd.Close();
            }

            return (lEOcupacion);
        }
    }
}