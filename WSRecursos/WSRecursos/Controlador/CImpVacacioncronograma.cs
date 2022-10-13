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
    public class CImpVacacioncronograma
    {
        public List<EImpVacacioncronograma> Listar_ImpVacacioncronograma(SqlConnection con, Int32 id, Int32 anhio)
        {
            List<EImpVacacioncronograma> lEImpVacacioncronograma = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_VACACIONES_CRONOGRAMA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEImpVacacioncronograma = new List<EImpVacacioncronograma>();

                EImpVacacioncronograma obEImpVacacioncronograma = null;
                while (drd.Read())
                {
                    obEImpVacacioncronograma = new EImpVacacioncronograma();
                    obEImpVacacioncronograma.i_id = drd["i_id"].ToString();
                    obEImpVacacioncronograma.v_dni = drd["v_dni"].ToString();
                    obEImpVacacioncronograma.v_nombres = drd["v_nombres"].ToString();
                    obEImpVacacioncronograma.d_ingreso = drd["d_ingreso"].ToString();
                    obEImpVacacioncronograma.v_area = drd["v_area"].ToString();
                    obEImpVacacioncronograma.v_cargo = drd["v_cargo"].ToString();
                    obEImpVacacioncronograma.d_finicio = drd["d_finicio"].ToString();
                    obEImpVacacioncronograma.d_ffin = drd["d_ffin"].ToString();
                    obEImpVacacioncronograma.v_periodo = drd["v_periodo"].ToString();
                    obEImpVacacioncronograma.i_dias = drd["i_dias"].ToString();
                    obEImpVacacioncronograma.v_firma_jefe = drd["v_firma_jefe"].ToString();
                    obEImpVacacioncronograma.v_firma_personal = drd["v_firma_personal"].ToString();
                    lEImpVacacioncronograma.Add(obEImpVacacioncronograma);
                }
                drd.Close();
            }

            return (lEImpVacacioncronograma);
        }
    }
}